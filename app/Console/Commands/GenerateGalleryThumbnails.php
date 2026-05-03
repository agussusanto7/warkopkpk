<?php

namespace App\Console\Commands;

use App\Models\Gallery;
use App\Services\ImageCompressService;
use Illuminate\Console\Command;

class GenerateGalleryThumbnails extends Command
{
    protected $signature = 'gallery:generate-thumbnails {--force : Generate ulang walaupun sudah ada}';
    protected $description = 'Generate thumbnails untuk gallery yang belum punya thumbnail';

    public function handle(): int
    {
        $this->info('🔄 Memulai generate thumbnails...');
        $this->newLine();

        $imageService = new ImageCompressService();

        // Get galleries that need thumbnail generation
        $galleries = Gallery::where(function($query) {
            $query->whereNull('cover_thumbnail')
                  ->orWhereNull('thumbnails');
        })->get();

        if ($galleries->isEmpty()) {
            $this->info('✅ Semua gallery sudah punya thumbnail!');
            return Command::SUCCESS;
        }

        $total = $galleries->count();
        $this->info("📷 Ditemukan $total gallery yang perlu di-generate thumbnails-nya");
        $this->newLine();

        $progressBar = $this->output->createProgressBar($total);
        $progressBar->start();

        foreach ($galleries as $gallery) {
            $this->processGallery($gallery, $imageService);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);
        $this->info("✅ Selesai! $total gallery diproses.");
        $this->info("📁 Thumbnail tersimpan di: storage/app/public/thumbnails/");

        return Command::SUCCESS;
    }

    protected function processGallery(Gallery $gallery, ImageCompressService $imageService): void
    {
        try {
            // Process cover image thumbnail
            if ($gallery->cover_image && !$gallery->cover_thumbnail) {
                try {
                    $result = $imageService->compressAndStoreWithThumbnailFromPath($gallery->cover_image);
                    $gallery->cover_thumbnail = $result['thumbnail'];
                    $this->line("   ✓ Cover: {$result['thumbnail']}");
                } catch (\Exception $e) {
                    $this->warn("   ⚠️ Gagal thumbnail cover: " . $e->getMessage());
                }
            }

            // Process photos thumbnails
            $photos = $gallery->photos ?? [];
            if (!empty($photos) && !$gallery->thumbnails) {
                $thumbs = [];
                foreach ($photos as $index => $photoPath) {
                    try {
                        $result = $imageService->compressAndStoreWithThumbnailFromPath($photoPath);
                        $thumbs[] = $result['thumbnail'];
                        $this->line("   ✓ Photo [$index]: {$result['thumbnail']}");
                    } catch (\Exception $e) {
                        $this->warn("   ⚠️ Gagal thumbnail foto [$index]: " . $e->getMessage());
                        $thumbs[] = null;
                    }
                }

                // Only save if we have valid thumbnails
                $validThumbs = array_filter($thumbs);
                if (!empty($validThumbs)) {
                    $gallery->thumbnails = $thumbs;
                }
            }

            $gallery->save();

        } catch (\Exception $e) {
            $this->warn("   ❌ Error processing gallery ID {$gallery->id}: " . $e->getMessage());
        }
    }
}