<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\SiteImage;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDatabaseController extends Controller
{
    public function index()
    {
        $tables = [
            [
                'name' => 'menu_items',
                'label' => '📋 Menu',
                'count' => MenuItem::count(),
                'route' => 'admin.database.menu'
            ],
            [
                'name' => 'site_images',
                'label' => '🖼️ Foto Website',
                'count' => SiteImage::count(),
                'route' => null
            ],
            [
                'name' => 'site_settings',
                'label' => '⚙️ Settings',
                'count' => SiteSetting::count(),
                'route' => null
            ],
            [
                'name' => 'testimonials',
                'label' => '💬 Testimonials',
                'count' => Testimonial::count(),
                'route' => null
            ],
            [
                'name' => 'users',
                'label' => '👤 Users',
                'count' => User::count(),
                'route' => null
            ],
        ];

        return view('admin.database.index', compact('tables'));
    }

    public function menu(Request $request)
    {
        $query = MenuItem::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $menuItems = $query->orderBy('id')->paginate(20);

        // Get column info
        $columns = [
            ['name' => 'id', 'type' => 'bigint', 'label' => 'ID'],
            ['name' => 'name', 'type' => 'varchar(255)', 'label' => 'Nama Menu'],
            ['name' => 'description', 'type' => 'text', 'label' => 'Deskripsi'],
            ['name' => 'notes', 'type' => 'text', 'label' => 'Catatan'],
            ['name' => 'price', 'type' => 'decimal(10,0)', 'label' => 'Harga'],
            ['name' => 'category', 'type' => 'varchar(255)', 'label' => 'Kategori'],
            ['name' => 'category_icon', 'type' => 'varchar(255)', 'label' => 'Icon'],
            ['name' => 'image', 'type' => 'varchar(255)', 'label' => 'Foto'],
            ['name' => 'is_available', 'type' => 'boolean', 'label' => 'Tersedia'],
            ['name' => 'sort_order', 'type' => 'int', 'label' => 'Urutan'],
            ['name' => 'created_at', 'type' => 'timestamp', 'label' => 'Dibuat'],
            ['name' => 'updated_at', 'type' => 'timestamp', 'label' => 'Diupdate'],
        ];

        return view('admin.database.menu', compact('menuItems', 'columns'));
    }
}
