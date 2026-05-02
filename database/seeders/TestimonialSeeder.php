<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Leo Juniarto',
                'text' => 'Kopi susunya juara! Tempat ngopi paling nyaman di kota ini. Barista-nya ramah dan kopinya selalu konsisten.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Eka Bayu Bachtiar Ferdiansa',
                'text' => 'Suasananya cozy banget, cocok buat kerja atau nongkrong. Menu makanannya juga enak-enak!',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Agus Susanto',
                'text' => 'Warkop KPK jadi tempat favorit saya untuk kerjain tugas sekolah. WiFi kencang, kopi mantap, harga bersahabat.',
                'rating' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name']],
                $testimonial
            );
        }
    }
}
