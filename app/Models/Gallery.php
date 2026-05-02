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
        'photos',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'event_date' => 'date',
        'photos' => 'array',
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
        // Support both old path (with storage/) and new path
        $path = ltrim($this->cover_image, '/');
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }
        return asset('storage/' . $path);
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
            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }
            return asset('storage/' . $path);
        }, $photos)));
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