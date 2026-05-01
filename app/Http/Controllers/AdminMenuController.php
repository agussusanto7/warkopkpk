<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMenuController extends Controller
{
    public function dashboard()
    {
        $totalMenus = MenuItem::count();
        $totalKopi = MenuItem::where('category', 'kopi')->count();
        $totalNonKopi = MenuItem::where('category', 'non-kopi')->count();
        $totalMakanan = MenuItem::where('category', 'makanan')->count();
        $totalSnack = MenuItem::where('category', 'snack')->count();
        $recentMenus = MenuItem::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalMenus', 'totalKopi', 'totalNonKopi', 'totalMakanan', 'totalSnack', 'recentMenus'));
    }

    public function index(Request $request)
    {
        $query = MenuItem::query();

        if ($request->filled('filter') && $request->filter === 'favorite') {
            $query->where('is_favorite', true);
        } elseif ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $menuItems = $query->orderBy('category')->orderBy('sort_order')->get();
        return view('admin.menu.index', compact('menuItems'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:kopi,non-kopi,makanan,snack',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available' => 'boolean',
            'is_favorite' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $icons = ['kopi' => '☕', 'non-kopi' => '🍵', 'makanan' => '🍽️', 'snack' => '🍟'];
        $validated['category_icon'] = $icons[$validated['category']] ?? '☕';
        $validated['is_available'] = $request->has('is_available');
        $validated['is_favorite'] = $request->has('is_favorite');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu-images', 'public');
        }

        MenuItem::create($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(MenuItem $menuItem)
    {
        return view('admin.menu.edit', compact('menuItem'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:kopi,non-kopi,makanan,snack',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available' => 'boolean',
            'is_favorite' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $icons = ['kopi' => '☕', 'non-kopi' => '🍵', 'makanan' => '🍽️', 'snack' => '🍟'];
        $validated['category_icon'] = $icons[$validated['category']] ?? '☕';
        $validated['is_available'] = $request->has('is_available');
        $validated['is_favorite'] = $request->has('is_favorite');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
            $validated['image'] = $request->file('image')->store('menu-images', 'public');
        }

        $menuItem->update($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(MenuItem $menuItem)
    {
        // Delete image if exists
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }
        $menuItem->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
    }

    public function deleteImage(MenuItem $menuItem)
    {
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
            $menuItem->update(['image' => null]);
        }
        return redirect()->back()->with('success', 'Foto menu berhasil dihapus!');
    }
}
