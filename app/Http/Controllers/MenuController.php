<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\SiteImage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::where('is_available', true)->orderBy('category')->orderBy('sort_order')->get();

        $categories = [];
        foreach ($menuItems as $item) {
            $key = $item->category;
            if (!isset($categories[$key])) {
                $titles = ['kopi' => 'Kopi', 'non-kopi' => 'Non-Kopi', 'makanan' => 'Makanan', 'snack' => 'Snack'];
                $categories[$key] = [
                    'title' => $titles[$key] ?? ucfirst($key),
                    'icon' => $item->category_icon,
                    'items' => [],
                ];
            }
            $categories[$key]['items'][] = [
                'name' => $item->name,
                'desc' => $item->description,
                'notes' => $item->notes,
                'price' => $item->formatted_price,
                'image' => $item->image ? '/img/' . $item->image : 'images/coffee-latte.png',
            ];
        }

        $menuHeaderImage = SiteImage::getImage('menu_header');

        return view('menu', compact('categories', 'menuHeaderImage'));
    }
}
