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
    ];

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Kompres dan simpan gambar
     *
     * @param UploadedFile $file File gambar yang di-upload
     * @param string $path Path tujuan penyimpanan (misal: 'menu-images', 'site-images', 'galleries', 'galleries/photos')
     * @param string|null $filename Nama file custom (optional, default: hash)
     * @return string Path file yang tersimpan
     */
    public function compressAndStore(UploadedFile $file, string $path, ?string $filename = null): string
    {
        // Dapatkan konfigurasi berdasarkan path
        $config = $this->getConfigForPath($path);

        // Baca gambar
        $image = $this->manager->read($file);

        // Dapatkan dimensi asli
        $originalWidth = $image->width();
        $originalHeight = $image->height();

        // Hitung dimensi baru jika perlu (resize dengan aspect ratio)
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

            // Resize gambar
            $image = $image->resize((int) $newWidth, (int) $newHeight);
        }

        // Generate nama file jika tidak disediakan
        if (!$filename) {
            $filename = $this->generateFilename($file);
        }

        // Encode dengan kompresi
        $encoded = $image->toPng($config['quality']); // Selalu gunakan PNG untuk kualitas terbaik

        // Simpan ke storage
        $fullPath = $path . '/' . $filename;
        Storage::disk('public')->put($fullPath, $encoded);

        return $fullPath;
    }

    /**
     * Kompres multiple gambar (untuk gallery photos, dll)
     *
     * @param array $files Array dari UploadedFile
     * @param string $path Path tujuan
     * @return array Array dari path file yang tersimpan
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
        // Cek exact match dulu
        if (isset($this->config[$path])) {
            return $this->config[$path];
        }

        // Cek prefix match (untuk nested paths)
        foreach ($this->config as $key => $config) {
            if (str_starts_with($path, $key)) {
                return $config;
            }
        }

        // Default config jika tidak ditemukan
        return [
            'quality' => 80,
            'max_width' => 1200,
            'max_height' => 1200,
        ];
    }

    /**
     * Generate nama file unik dengan hash
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = 'png'; // Selalu gunakan PNG untuk kualitas terbaik
        $hash = md5($file->getClientOriginalName() . time() . rand(1000, 9999));
        return $hash . '.' . $extension;
    }

    /**
     * Dapatkan info ukuran file sebelum dan sesudah kompresi (untuk logging/debug)
     */
    public function getSizeComparison(UploadedFile $file, string $path): array
    {
        $originalSize = $file->getSize();

        // Kompres sementara untuk ukuran
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

        $encoded = $image->toPng($config['quality']);
        $compressedSize = strlen($encoded);

        return [
            'original' => $this->formatBytes($originalSize),
            'compressed' => $this->formatBytes($compressedSize),
            'saved' => $this->formatBytes($originalSize - $compressedSize),
            'saved_percent' => round((($originalSize - $compressedSize) / $originalSize) * 100, 1),
            'original_dimensions' => $originalWidth . 'x' . $originalHeight,
            'new_dimensions' => (int) $newWidth . 'x' . (int) $newHeight,
        ];
    }

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
