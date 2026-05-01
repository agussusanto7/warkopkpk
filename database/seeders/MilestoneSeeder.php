<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Milestone;

class MilestoneSeeder extends Seeder
{
    public function run(): void
    {
        $milestones = [
            [
                'year' => 2021,
                'title' => 'Awal Mula',
                'description' => 'Warkop KPK dibuka pertama kali sebagai kedai kopi kecil dengan hanya 5 menu dan 3 meja.',
                'sort_order' => 1,
            ],
            [
                'year' => 2022,
                'title' => 'Ekspansi Menu',
                'description' => 'Menambah menu makanan dan non-kopi. Tim barista bertambah menjadi 5 orang bersertifikat.',
                'sort_order' => 2,
            ],
            [
                'year' => 2023,
                'title' => 'Renovasi & Upgrade',
                'description' => 'Renovasi besar-besaran dengan konsep industrial-rustic. Kapasitas meningkat 3x lipat.',
                'sort_order' => 3,
            ],
            [
                'year' => 2024,
                'title' => '5000+ Cups Served',
                'description' => 'Mencapai milestone 5000+ cup kopi terjual per bulan. Rating 4.9 di Google Maps.',
                'sort_order' => 4,
            ],
            [
                'year' => 2025,
                'title' => 'Digital & Delivery',
                'description' => 'Meluncurkan website resmi dan layanan delivery. Bermitra dengan platform online.',
                'sort_order' => 5,
            ],
        ];

        foreach ($milestones as $milestone) {
            Milestone::create($milestone);
        }
    }
}
