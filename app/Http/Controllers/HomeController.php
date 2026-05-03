<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\SiteImage;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured items based on is_favorite flag (all favorites will be shown)
        $menuHighlights = MenuItem::where('is_available', true)
            ->where('is_favorite', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'description' => $item->description,
                    'price' => $item->formatted_price,
                    'image' => $item->image ? '/img/' . $item->image : 'images/coffee-latte.png',
                ];
            })->toArray();

        // Get testimonials from database
        $testimonials = Testimonial::where('is_active', true)
            ->orderByDesc('rating')
            ->get()
            ->map(function ($t) {
                return [
                    'name' => $t->name,
                    'text' => $t->text,
                    'rating' => $t->rating,
                ];
            })->toArray();

        // Get dynamic images from database
        $heroImage = SiteImage::getImage('hero');
        $baristaImage = SiteImage::getImage('barista');

        // Get stats from database
        $stats = [
            'cups' => SiteSetting::getValue('stats_cups', '5000'),
            'menu' => SiteSetting::getValue('stats_menu', '50'),
            'rating' => SiteSetting::getValue('stats_rating', '4.9'),
        ];

        return view('home', compact('menuHighlights', 'testimonials', 'heroImage', 'baristaImage', 'stats'));
    }
}
