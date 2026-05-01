<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteImage extends Model
{
    protected $fillable = ['section_key', 'title', 'image_path', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public static function getImage($sectionKey)
    {
        $image = self::where('section_key', $sectionKey)->where('is_active', true)->latest()->first();
        return $image ? asset('storage/' . $image->image_path) : null;
    }

    public static function getSections()
    {
        return [
            'hero' => 'Hero / Banner Utama',
            'menu_header' => 'Header Halaman Menu',
            'about_header' => 'Header Halaman About',
            'contact_header' => 'Header Halaman Kontak',
            'about_story' => 'Foto Cerita (About)',
            'barista' => 'Foto Barista',
        ];
    }
}
