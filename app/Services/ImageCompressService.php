<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageCompressService
{
    protected ImageManager $manager;

    // Konfigurasi kompresi per jenis gambar
    protected array $config = [
        // Menu images - butuh kualitas baik, ukuran medium
        'menu-images' => [
            'quality' => 80,
            'max_width' => 1200,
            'max_height' => 1200,
        ],

        // Site images (hero, header, etc) - kualitas tinggi, ukuran besar
        'site-images' => [
            'quality' => 85,
            'max_width' => 1920,
            'max_height' => 1920,
        ],

        // Gallery cover images - kualitas baik, ukuran medium
        'galleries' => [
            'quality' => 82,
            'max_width' => 1400,
            'max_height' => 1000,
        ],

        // Gallery photos - kualitas medium, ukuran medium
        'galleries/photos' => [
            'quality' => 75,
            'max_width' => 1200,
            'max_height' => 900,
        ],

        // Thumbnails - ukuran kecil, kualitas cukup
        'thumbnails' => [
            'quality' => 70,
            'max_width' => 400,
            'max_height' => 300,
        ],
    ];

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Kompres dan simpan gambar
     */
    public function compressAndStore(UploadedFile $file, string $path, ?string $filename = null): string
    {
        $config = $this->getConfigForPath($path);
        $image = $this->manager->read($file);

        $originalWidth = $image->width();
        $originalHeight = $image->height();

        $newWidth = $originalWidth;
        $newHeight = $originalHeight;

        if ($originalWidth > $config['max_width'] || $originalHeight > $config['max_height']) {
            $aspectRatio = $originalWidth / $originalHeight;

            if ($originalWidth > $config['max_width']) {
                $newWidth = $config['max_width'];
                $newHeight = $newWidth / $aspectRatio;
            }

            if ($newHeight > $config['max_height']) {
                $newHeight = $config['max_height'];
                $newWidth = $newHeight * $aspectRatio;
            }

            $image = $image->resize((int) $newWidth, (int) $newHeight);
        }

        if (!$filename) {
            $filename = $this->generateFilename($file);
        }

        $encoded = $image->toPng($config['quality']);

        $fullPath = $path . '/' . $filename;
        Storage::disk('public')->put($fullPath, $encoded);

        return $fullPath;
    }

    /**
     * Kompres dan generate THUMBNAIL secara bersamaan
     * Mengembalikan array: ['original' => path, 'thumbnail' => path]
     */
    public function compressAndStoreWithThumbnail(UploadedFile $file, string $path): array
    {
        $originalPath = $this->compressAndStore($file, $path);

        // Generate thumbnail filename
        $thumbFilename = $this->generateThumbnailFilename($originalPath);

        // Kompres ulang dengan ukuran thumbnail
        $config = $this->config['thumbnails'];
        $image = $this->manager->read($file);

        $originalWidth = $image->width();
        $originalHeight = $image->height();

        $aspectRatio = $originalWidth / $originalHeight;

        $newWidth = $config['max_width'];
        $newHeight = $config['max_width'] / $aspectRatio;

        if ($newHeight > $config['max_height']) {
            $newHeight = $config['max_height'];
            $newWidth = $newHeight * $aspectRatio;
        }

        $image = $image->resize((int) $newWidth, (int) $newHeight);
        $encoded = $image->toPng($config['quality']);

        $thumbPath = 'thumbnails/' . $thumbFilename;
        Storage::disk('public')->put($thumbPath, $encoded);

        return [
            'original' => $originalPath,
            'thumbnail' => $thumbPath,
        ];
    }

    /**
     * Kompres multiple gambar (untuk gallery photos)
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
        $extension = 'png';
        $hash = md5($file->getClientOriginalName() . time() . rand(1000, 9999));
        return $hash . '.' . $extension;
    }

    /**
     * Generate nama file untuk thumbnail
     */
    protected function generateThumbnailFilename(string $originalPath): string
    {
        $info = pathinfo($originalPath);
        return $info['filename'] . '_thumb.' . ($info['extension'] ?? 'png');
    }

    /**
     * Format bytes ke readable string
     */
    protected function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
