<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $categories = GalleryCategory::active()->sorted()->get();

        $query = Gallery::with('category')->published()->sorted();

        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Handle AJAX request
        if ($request->ajax()) {
            $galleries = $query->paginate(9);
            return response()->json([
                'html' => view('gallery-grid-partial', compact('galleries'))->render(),
                'hasMore' => $galleries->hasMorePages(),
            ]);
        }

        $galleries = $query->paginate(9);

        return view('gallery', compact('galleries', 'categories'));
    }

    /**
     * API endpoint untuk AJAX gallery filtering
     */
    public function apiIndex(Request $request)
    {
        $categories = GalleryCategory::active()->sorted()->get();

        $query = Gallery::with('category')->published()->sorted();

        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        $galleries = $query->paginate(9);

        $currentCategory = $request->get('category', 'all');

        // Generate filter buttons HTML
        $filtersHtml = '<button class="filter-btn ' . ($currentCategory === 'all' ? 'active' : '') . '" onclick="loadGallery(null)">📷 Semua Momen</button>';
        foreach ($categories as $cat) {
            $isActive = $currentCategory === $cat->slug;
            $filtersHtml .= '<button class="filter-btn ' . ($isActive ? 'active' : '') . '" onclick="loadGallery(\'' . $cat->slug . '\')"' . ($isActive ? '' : ' style="border-color: ' . $cat->color . '40;"') . '>' . $cat->icon . ' ' . $cat->name . '</button>';
        }

        return response()->json([
            'html' => view('gallery-grid-partial', compact('galleries'))->render(),
            'hasMore' => $galleries->hasMorePages(),
            'total' => $galleries->total(),
            'filtersHtml' => $filtersHtml,
            'currentCategory' => $currentCategory,
        ]);
    }

    public function show(Gallery $gallery)
    {
        abort_unless($gallery->is_published, 404);

        $gallery->load('category');

        $related = Gallery::with('category')
            ->published()
            ->byCategory($gallery->category->slug)
            ->where('id', '!=', $gallery->id)
            ->sorted()
            ->limit(6)
            ->get();

        return view('gallery-detail', compact('gallery', 'related'));
    }
}