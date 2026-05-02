<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }

    public static function getDefaultCategories(): array
    {
        return [
            ['name' => 'Buka Bersama', 'slug' => 'buka-bersama', 'icon' => '🌙', 'color' => '#8b5cf6'],
            ['name' => 'Nobar Bola', 'slug' => 'nobar-bola', 'icon' => '⚽', 'color' => '#10b981'],
            ['name' => 'Live Music', 'slug' => 'live-music', 'icon' => '🎵', 'color' => '#f59e0b'],
            ['name' => 'Outing & Trip', 'slug' => 'outing-trip', 'icon' => '🚗', 'color' => '#3b82f6'],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'icon' => '📷', 'color' => '#6b7280'],
        ];
    }
}