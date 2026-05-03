<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'notes',
        'price',
        'category',
        'category_icon',
        'image',
        'is_available',
        'is_favorite',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:0',
        'is_available' => 'boolean',
        'is_favorite' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return url('/img/' . $this->image);
        }
        return null;
    }
}
