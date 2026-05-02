<?php

namespace App\Providers;

use App\Models\GalleryCategory;
use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share site settings globally to all views
        View::composer('*', function ($view) {
            $view->with('siteSettings', [
                'address' => SiteSetting::getValue('address', 'Jl. Kopi Nusantara No. 88, Jakarta'),
                'phone' => SiteSetting::getValue('phone', '+62 812-3456-7890'),
                'email' => SiteSetting::getValue('email', 'hello@warkopkpk.com'),
                'whatsapp' => SiteSetting::getValue('whatsapp', '6281234567890'),
                'jam_buka' => SiteSetting::getValue('jam_buka', 'Senin - Jumat: 08:00 - 23:00'),
            ]);
        });

        // Share gallery categories for navbar dropdown
        View::composer('layouts.app', function ($view) {
            $view->with('galleryCategories', GalleryCategory::active()->sorted()->get());
        });
    }
}
