<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminImageController;
use App\Http\Controllers\AdminDatabaseController;
use App\Http\Controllers\AdminFeedbackController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminMilestoneController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AdminGalleryController;

// Serve gallery images via PHP (tanpa exec/symlink)
Route::get('/gallery-img/{path}', function ($path) {
    // Sanitize path - prevent directory traversal
    $safePath = str_replace(['../', '..\\', "\0", '..'], '', $path);
    $file = storage_path('app/public/' . $safePath);

    if (file_exists($file)) {
        $mime = mime_content_type($file);
        return response(file_get_contents($file))
            ->header('Content-Type', $mime)
            ->header('Cache-Control', 'public, max-age=31536000');
    }
    abort(404);
})->where('path', '.*');

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{gallery}', [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Auth routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (protected)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminMenuController::class, 'dashboard'])->name('dashboard');
    Route::get('/menu', [AdminMenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [AdminMenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [AdminMenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{menuItem}/edit', [AdminMenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{menuItem}', [AdminMenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menuItem}', [AdminMenuController::class, 'destroy'])->name('menu.destroy');
    Route::delete('/menu/{menuItem}/image', [AdminMenuController::class, 'deleteImage'])->name('menu.deleteImage');

    // Image management
    Route::get('/images', [AdminImageController::class, 'index'])->name('images.index');
    Route::get('/images/create', [AdminImageController::class, 'create'])->name('images.create');
    Route::post('/images', [AdminImageController::class, 'store'])->name('images.store');
    Route::post('/images/{siteImage}/activate', [AdminImageController::class, 'activate'])->name('images.activate');
    Route::delete('/images/{siteImage}', [AdminImageController::class, 'destroy'])->name('images.destroy');

    // Database browser
    Route::get('/database', [AdminDatabaseController::class, 'index'])->name('database.index');
    Route::get('/database/menu', [AdminDatabaseController::class, 'menu'])->name('database.menu');

    // Feedback management
    Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback/{feedback}/read', [AdminFeedbackController::class, 'markAsRead'])->name('feedback.read');
    Route::delete('/feedback/{feedback}', [AdminFeedbackController::class, 'destroy'])->name('feedback.destroy');

    // Profile management
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');

    // Milestone management
    Route::get('/milestones', [AdminMilestoneController::class, 'index'])->name('milestones.index');
    Route::post('/milestones', [AdminMilestoneController::class, 'store'])->name('milestones.store');
    Route::put('/milestones/{milestone}', [AdminMilestoneController::class, 'update'])->name('milestones.update');
    Route::delete('/milestones/{milestone}', [AdminMilestoneController::class, 'destroy'])->name('milestones.destroy');

    // Gallery management
    Route::get('/gallery', [AdminGalleryController::class, 'index'])->name('gallery.index');
    Route::get('/gallery/create', [AdminGalleryController::class, 'create'])->name('gallery.create');
    Route::post('/gallery', [AdminGalleryController::class, 'store'])->name('gallery.store');
    Route::get('/gallery/{gallery}/edit', [AdminGalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('/gallery/{gallery}', [AdminGalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{gallery}', [AdminGalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::post('/gallery/{gallery}/toggle', [AdminGalleryController::class, 'togglePublish'])->name('gallery.toggle');

    // Gallery categories
    Route::get('/gallery/categories', [AdminGalleryController::class, 'categoryIndex'])->name('gallery.categories');
    Route::post('/gallery/categories', [AdminGalleryController::class, 'categoryStore'])->name('gallery.category.store');
    Route::put('/gallery/categories/{category}', [AdminGalleryController::class, 'categoryUpdate'])->name('gallery.category.update');
    Route::delete('/gallery/categories/{category}', [AdminGalleryController::class, 'categoryDestroy'])->name('gallery.category.destroy');

    // Remove single photo
    Route::delete('/gallery/{gallery}/photo', [AdminGalleryController::class, 'removePhoto'])->name('gallery.removePhoto');
});
