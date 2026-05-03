<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageCompressService
{
    protected $manager;
    protected $version;

    // Konfigurasi kompresi per jenis gambar
    protected array $config = [
        'menu-images' => [
            'quality' => 80,
            'max_width' => 1200,
            'max_height' => 1200,
        ],
        'site-images' => [
            'quality' => 85,
            'max_width' => 1920,
            'max_height' => 1920,
        ],
        'galleries' => [
            'quality' => 82,
            'max_width' => 1400,
            'max_height' => 1000,
        ],
        'galleries/photos' => [
            'quality' => 75,
            'max_width' => 1200,
            'max_height' => 900,
        ],
        'thumbnails' => [
            'quality' => 70,
            'max_width' => 400,
            'max_height' => 300,
        ],
    ];

    public function __construct()
    {
        $this->version = $this->detectVersion();

        if ($this->version >= 3) {
            // Intervention Image v3/v4
            $driver = new \Intervention\Image\Drivers\Gd\Driver();
            $this->manager = new ImageManager($driver);
        } else {
            // Intervention Image v2
            $this->manager = new ImageManager(['driver' => 'gd']);
        }
    }

    /**
     * Deteksi versi Intervention Image
     */
    protected function detectVersion(): int
    {
        // Cek apakah ada driver class (v3+)
        if (class_exists('Intervention\Image\Drivers\Gd\Driver')) {
            // Cek apakah method make() ada (v2 style) atau read() (v3 style)
            $manager = null;
            try {
                // Coba v2 syntax dulu
                $test = @new ImageManager(['driver' => 'gd']);
                if (method_exists($test, 'make')) {
                    return 2;
                }
            } catch (\Throwable $e) {
                // v2 gagal, berarti v3+
            }

            try {
                // Coba v3 syntax
                $driver = @new \Intervention\Image\Drivers\Gd\Driver();
                $test = @new ImageManager($driver);
                if (method_exists($test, 'read')) {
                    return 4;
                }
                return 3;
            } catch (\Throwable $e) {
                return 3;
            }
        }

        // Fallback ke v2
        return 2;
    }

    /**
     * Load image - support v2 & v3+
     */
    protected function loadImage($source)
    {
        if ($this->version >= 3) {
            return $this->manager->read($source);
        } else {
            return $this->manager->make($source);
        }
    }

    /**
     * Encode image - support v2 & v3+
     */
    protected function encodeImage($image, string $format = 'png', int $quality = 80)
    {
        if ($this->version >= 3) {
            return $image->toPng($quality);
        } else {
            return $image->encode($format, $quality);
        }
    }

    /**
     * Kompres dan simpan gambar
     */
    public function compressAndStore(UploadedFile $file, string $path, ?string $filename = null): string
    {
        $config = $this->getConfigForPath($path);
        $image = $this->loadImage($file);

        $originalWidth = $image->width();
        $originalHeight = $image->height();

        $newWidth = $originalWidth;
        $newHeight = $originalHeight;

        if ($originalWidth > $config['max_width'] || $originalHeight > $config['max_height']) {
            $aspectRatio = $originalWidth / $originalHeight;

            if ($originalWidth > $config['max_width']) {
                $newWidth = $config['max_width'];
                $newHeight = (int) ($newWidth / $aspectRatio);
            }

            if ($newHeight > $config['max_height']) {
                $newHeight = $config['max_height'];
                $newWidth = (int) ($newHeight * $aspectRatio);
            }

            $image->resize($newWidth, $newHeight);
        }

        if (!$filename) {
            $filename = $this->generateFilename($file);
        }

        $fullPath = $path . '/' . $filename;
        Storage::disk('public')->put($fullPath, $this->encodeImage($image, 'png', $config['quality']));

        return $fullPath;
    }

    /**
     * Kompres dan generate THUMBNAIL
     */
    public function compressAndStoreWithThumbnail(UploadedFile $file, string $path): array
    {
        $originalPath = $this->compressAndStore($file, $path);

        $thumbFilename = $this->generateThumbnailFilename($originalPath);
        $config = $this->config['thumbnails'];
        $image = $this->loadImage($file);

        $originalWidth = $image->width();
        $originalHeight = $image->height();

        $aspectRatio = $originalWidth / $originalHeight;

        $newWidth = $config['max_width'];
        $newHeight = (int) ($config['max_width'] / $aspectRatio);

        if ($newHeight > $config['max_height']) {
            $newHeight = $config['max_height'];
            $newWidth = (int) ($newHeight * $aspectRatio);
        }

        $image->resize($newWidth, $newHeight);
        $thumbPath = 'thumbnails/' . $thumbFilename;
        Storage::disk('public')->put($thumbPath, $this->encodeImage($image, 'png', $config['quality']));

        return [
            'original' => $originalPath,
            'thumbnail' => $thumbPath,
        ];
    }

    /**
     * Generate thumbnail dari file yang SUDAH ADA di storage
     */
    public function compressAndStoreWithThumbnailFromPath(string $existingPath): array
    {
        $thumbFilename = $this->generateThumbnailFilename($existingPath);

        $fullPath = storage_path('app/public/' . $existingPath);
        if (!file_exists($fullPath)) {
            throw new \Exception("File tidak ditemukan: $fullPath");
        }

        $config = $this->config['thumbnails'];
        $image = $this->loadImage($fullPath);

        $originalWidth = $image->width();
        $originalHeight = $image->height();

        $aspectRatio = $originalWidth / $originalHeight;

        $newWidth = $config['max_width'];
        $newHeight = (int) ($config['max_width'] / $aspectRatio);

        if ($newHeight > $config['max_height']) {
            $newHeight = $config['max_height'];
            $newWidth = (int) ($newHeight * $aspectRatio);
        }

        $image->resize($newWidth, $newHeight);
        $thumbPath = 'thumbnails/' . $thumbFilename;
        Storage::disk('public')->put($thumbPath, $this->encodeImage($image, 'png', $config['quality']));

        return [
            'original' => $existingPath,
            'thumbnail' => $thumbPath,
        ];
    }

    /**
     * Kompres multiple gambar
     */
    public function compressAndStoreMultiple(array $files, string $path): array
    {
        $paths = [];

        foreach ($files as $file) {
            if ($file && $file instanceof UploadedFile && $file->isValid()) {
                $paths[] = $this->compressAndStore($file, $path);
            }
        }

        return $paths;
    }

    /**
     * Dapatkan konfigurasi berdasarkan path
     */
    protected function getConfigForPath(string $path): array
    {
        if (isset($this->config[$path])) {
            return $this->config[$path];
        }

        foreach ($this->config as $key => $config) {
            if (str_starts_with($path, $key)) {
                return $config;
            }
        }

        return [
            'quality' => 80,
            'max_width' => 1200,
            'max_height' => 1200,
        ];
    }

    /**
     * Generate nama file unik
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $hash = md5($file->getClientOriginalName() . time() . rand(1000, 9999));
        return $hash . '.png';
    }

    /**
     * Generate nama file untuk thumbnail
     */
    protected function generateThumbnailFilename(string $originalPath): string
    {
        $info = pathinfo($originalPath);
        return $info['filename'] . '_thumb.' . ($info['extension'] ?? 'png');
    }
}