<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@warkopkpk.com'],
            [
                'name' => 'Admin KPK',
                'password' => Hash::make('warkopkpk1'),
            ]
        );

        // Seed menu items
        $menus = [
            // Kopi
            ['name' => 'Espresso', 'description' => 'Shot espresso premium single origin', 'price' => 15000, 'category' => 'kopi', 'category_icon' => '☕', 'sort_order' => 1],
            ['name' => 'Americano', 'description' => 'Espresso dengan hot water', 'price' => 18000, 'category' => 'kopi', 'category_icon' => '☕', 'sort_order' => 2],
            ['name' => 'Cappuccino', 'description' => 'Espresso, steamed milk, foam art', 'price' => 22000, 'category' => 'kopi', 'category_icon' => '☕', 'sort_order' => 3],
            ['name' => 'Cafe Latte', 'description' => 'Espresso dengan susu segar', 'price' => 22000, 'category' => 'kopi', 'category_icon' => '☕', 'sort_order' => 4],
            ['name' => 'Kopi Susu KPK', 'description' => 'Racikan khas kopi susu gula aren', 'price' => 18000, 'category' => 'kopi', 'category_icon' => '☕', 'sort_order' => 5],
            ['name' => 'Kopi Tubruk', 'description' => 'Kopi tradisional khas Indonesia', 'price' => 12000, 'category' => 'kopi', 'category_icon' => '☕', 'sort_order' => 6],
            ['name' => 'V60 Manual Brew', 'description' => 'Pour over biji pilihan barista', 'price' => 28000, 'category' => 'kopi', 'category_icon' => '☕', 'sort_order' => 7],
            ['name' => 'Cold Brew', 'description' => 'Kopi seduh dingin 18 jam', 'price' => 25000, 'category' => 'kopi', 'category_icon' => '☕', 'sort_order' => 8],
            ['name' => 'Affogato', 'description' => 'Espresso dengan ice cream vanilla', 'price' => 28000, 'category' => 'kopi', 'category_icon' => '☕', 'sort_order' => 9],
            ['name' => 'Mocha Latte', 'description' => 'Espresso, susu, dark chocolate', 'price' => 25000, 'category' => 'kopi', 'category_icon' => '☕', 'sort_order' => 10],

            // Non-Kopi
            ['name' => 'Matcha Latte', 'description' => 'Premium matcha dengan susu segar', 'price' => 25000, 'category' => 'non-kopi', 'category_icon' => '🍵', 'sort_order' => 1],
            ['name' => 'Taro Latte', 'description' => 'Taro premium dengan susu', 'price' => 22000, 'category' => 'non-kopi', 'category_icon' => '🍵', 'sort_order' => 2],
            ['name' => 'Red Velvet', 'description' => 'Red velvet dengan cream cheese foam', 'price' => 25000, 'category' => 'non-kopi', 'category_icon' => '🍵', 'sort_order' => 3],
            ['name' => 'Chocolate', 'description' => 'Dark chocolate premium', 'price' => 22000, 'category' => 'non-kopi', 'category_icon' => '🍵', 'sort_order' => 4],
            ['name' => 'Thai Tea', 'description' => 'Thai tea klasik dengan susu', 'price' => 18000, 'category' => 'non-kopi', 'category_icon' => '🍵', 'sort_order' => 5],
            ['name' => 'Lemon Tea', 'description' => 'Teh lemon segar', 'price' => 15000, 'category' => 'non-kopi', 'category_icon' => '🍵', 'sort_order' => 6],
            ['name' => 'Fresh Orange', 'description' => 'Jus jeruk segar', 'price' => 18000, 'category' => 'non-kopi', 'category_icon' => '🍵', 'sort_order' => 7],

            // Makanan
            ['name' => 'Nasi Goreng KPK', 'description' => 'Nasi goreng spesial racikan chef', 'price' => 25000, 'category' => 'makanan', 'category_icon' => '🍽️', 'sort_order' => 1],
            ['name' => 'Mie Goreng', 'description' => 'Mie goreng dengan telur dan sayuran', 'price' => 22000, 'category' => 'makanan', 'category_icon' => '🍽️', 'sort_order' => 2],
            ['name' => 'Indomie Spesial', 'description' => 'Indomie dengan topping lengkap', 'price' => 18000, 'category' => 'makanan', 'category_icon' => '🍽️', 'sort_order' => 3],
            ['name' => 'Roti Bakar', 'description' => 'Roti bakar dengan berbagai topping', 'price' => 15000, 'category' => 'makanan', 'category_icon' => '🍽️', 'sort_order' => 4],
            ['name' => 'Sandwich Club', 'description' => 'Sandwich dengan ayam, telur, sayuran', 'price' => 28000, 'category' => 'makanan', 'category_icon' => '🍽️', 'sort_order' => 5],
            ['name' => 'Pasta Aglio Olio', 'description' => 'Pasta dengan garlic dan olive oil', 'price' => 30000, 'category' => 'makanan', 'category_icon' => '🍽️', 'sort_order' => 6],

            // Snack
            ['name' => 'French Fries', 'description' => 'Kentang goreng crispy', 'price' => 18000, 'category' => 'snack', 'category_icon' => '🍟', 'sort_order' => 1],
            ['name' => 'Pisang Goreng', 'description' => 'Pisang goreng crispy madu', 'price' => 15000, 'category' => 'snack', 'category_icon' => '🍟', 'sort_order' => 2],
            ['name' => 'Croissant', 'description' => 'Butter croissant fresh from oven', 'price' => 20000, 'category' => 'snack', 'category_icon' => '🍟', 'sort_order' => 3],
            ['name' => 'Banana Split', 'description' => 'Pisang dengan ice cream & topping', 'price' => 28000, 'category' => 'snack', 'category_icon' => '🍟', 'sort_order' => 4],
            ['name' => 'Dimsum', 'description' => 'Aneka dimsum kukus segar', 'price' => 22000, 'category' => 'snack', 'category_icon' => '🍟', 'sort_order' => 5],
        ];

        foreach ($menus as $menu) {
            MenuItem::updateOrCreate(
                ['name' => $menu['name'], 'category' => $menu['category']],
                $menu
            );
        }
    }
}
