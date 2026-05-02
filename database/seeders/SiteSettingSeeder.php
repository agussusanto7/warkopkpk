<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'whatsapp',
                'value' => '6285704428138',
                'type' => 'phone',
                'group' => 'general',
            ],
            [
                'key' => 'phone',
                'value' => '6285704428138',
                'type' => 'phone',
                'group' => 'general',
            ],
            [
                'key' => 'email',
                'value' => 'hello@warkopkpk.com',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'address',
                'value' => 'Brongkos, Siraman, Kec. Kesamben, Kabupaten Blitar, Jawa Timur 66191',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'jam_buka',
                'value' => "Senin - Jumat: 08:00 - 23:00, Sabtu: 09:00 - 00:00, Minggu: 09:00 - 22:00",
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'stats_cups',
                'value' => '5000',
                'type' => 'number',
                'group' => 'general',
            ],
            [
                'key' => 'stats_menu',
                'value' => '50',
                'type' => 'number',
                'group' => 'general',
            ],
            [
                'key' => 'stats_rating',
                'value' => '4.9',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'maps_embed',
                'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d303.74258107952653!2d112.3518165!3d-8.1403326!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78968a0294879d%3A0x8f5867007101682e!2sWarkop%20Cethe%20KPK!5e1!3m2!1sid!2sid!4v1777608801115!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'type' => 'url',
                'group' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
