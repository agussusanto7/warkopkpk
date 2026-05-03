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