<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;

class GalleryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $defaults = GalleryCategory::getDefaultCategories();
        foreach ($defaults as $index => $cat) {
            GalleryCategory::updateOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, ['sort_order' => $index + 1])
            );
        }
    }
}