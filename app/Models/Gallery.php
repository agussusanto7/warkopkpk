<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'event_date',
        'cover_image',
        'cover_thumbnail',
        'photos',
        'thumbnails',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'event_date' => 'date',
        'photos' => 'array',
        'thumbnails' => 'array',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeSorted($query)
    {
        return $query->orderByDesc('event_date');
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        if (!$this->cover_image) {
            return null;
        }
        $path = ltrim($this->cover_image, '/');
        return url('/gallery-img/' . $path);
    }

    /**
     * Get thumbnail URL for cover image (untuk grid/list view)
     */
    public function getCoverThumbnailUrlAttribute(): ?string
    {
        if (!$this->cover_thumbnail) {
            return $this->cover_image_url; // Fallback ke cover_image_url
        }
        $path = ltrim($this->cover_thumbnail, '/');
        return url('/gallery-img/' . $path);
    }

    public function getPhotoUrlsAttribute(): array
    {
        if (!$this->photos) {
            return [];
        }
        $photos = (array) $this->photos;
        if (empty($photos)) {
            return [];
        }
        return array_values(array_filter(array_map(function ($photo) {
            if (!$photo || !is_string($photo)) {
                return null;
            }
            $path = ltrim($photo, '/');
            return url('/gallery-img/' . $path);
        }, $photos)));
    }

    /**
     * Get thumbnail URLs for photos (untuk grid/list view)
     */
    public function getThumbnailUrlsAttribute(): array
    {
        if (!$this->thumbnails) {
            return $this->photo_urls; // Fallback ke photo_urls
        }
        $thumbs = (array) $this->thumbnails;
        if (empty($thumbs)) {
            return $this->photo_urls;
        }
        return array_values(array_filter(array_map(function ($thumb) {
            if (!$thumb || !is_string($thumb)) {
                return null;
            }
            $path = ltrim($thumb, '/');
            return url('/gallery-img/' . $path);
        }, $thumbs)));
    }

    public function getFormattedDateAttribute(): string
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $this->event_date->day . ' ' . $bulan[$this->event_date->month] . ' ' . $this->event_date->year;
    }

    public function getPhotoCountAttribute(): int
    {
        return is_array($this->photos) ? count($this->photos) : 0;
    }
}