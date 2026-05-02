<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class AdminGalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with('category')->sorted();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        $galleries = $query->paginate(10);
        $categories = GalleryCategory::active()->sorted()->get();

        return view('admin.gallery.index', compact('galleries', 'categories'));
    }

    public function create()
    {
        $categories = GalleryCategory::active()->sorted()->get();
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $title = trim($request->input('title'));
        $categoryId = $request->input('category_id');
        $eventDate = $request->input('event_date');

        if (empty($title) || empty($categoryId) || empty($eventDate)) {
            return redirect()->back()->withInput()->with('error', 'Judul, kategori, dan tanggal wajib diisi!');
        }

        $category = GalleryCategory::find($categoryId);
        if (!$category) {
            return redirect()->back()->withInput()->with('error', 'Kategori tidak ditemukan!');
        }

        $data = [
            'title' => $title,
            'category_id' => (int) $categoryId,
            'event_date' => $eventDate,
            'description' => trim($request->input('description')) ?: null,
            'is_published' => $request->has('is_published'),
            'sort_order' => 0,
        ];

        // Cover image
        $file = $request->file('cover_image');
        if ($file && $file->getSize() > 0) {
            $data['cover_image'] = $file->store('galleries', 'public');
        }

        // Photos
        $filePhotos = $request->file('photos');
        if ($filePhotos) {
            $allFiles = is_array($filePhotos) ? $filePhotos : [$filePhotos];
            $paths = [];
            foreach ($allFiles as $p) {
                if ($p && $p->getSize() > 0) {
                    $paths[] = $p->store('galleries/photos', 'public');
                }
            }
            if (!empty($paths)) {
                $data['photos'] = $paths;
            }
        }

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Momen berhasil ditambahkan!');
    }

    public function edit(Gallery $gallery)
    {
        $categories = GalleryCategory::active()->sorted()->get();
        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        // Get raw input
        $title = trim($request->input('title'));
        $categoryId = $request->input('category_id');
        $eventDate = $request->input('event_date');
        $description = trim($request->input('description'));

        // Validate required fields
        if (empty($title)) {
            return redirect()->back()->withInput()->with('error', 'Judul wajib diisi!');
        }
        if (empty($categoryId)) {
            return redirect()->back()->withInput()->with('error', 'Kategori wajib dipilih!');
        }
        if (empty($eventDate)) {
            return redirect()->back()->withInput()->with('error', 'Tanggal wajib diisi!');
        }

        // Verify category
        $category = GalleryCategory::find($categoryId);
        if (!$category) {
            return redirect()->back()->withInput()->with('error', 'Kategori tidak valid!');
        }

        // Build data to update
        $data = [
            'title' => $title,
            'category_id' => (int) $categoryId,
            'event_date' => $eventDate,
            'description' => $description ?: null,
            'is_published' => $request->has('is_published'),
        ];

        // Cover image — replace if new file uploaded
        $file = $request->file('cover_image');
        if ($file && $file->getSize() > 0) {
            // Delete old cover
            if ($gallery->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($gallery->cover_image);
            }
            $data['cover_image'] = $file->store('galleries', 'public');
        }

        // Photos — add new OR replace all
        $filePhotos = $request->file('photos');
        $replaceMode = $request->boolean('replace_photos');

        if ($filePhotos) {
            $allFiles = is_array($filePhotos) ? $filePhotos : [$filePhotos];
            $newPaths = [];

            foreach ($allFiles as $p) {
                if ($p && $p->getSize() > 0) {
                    $newPaths[] = $p->store('galleries/photos', 'public');
                }
            }

            if (!empty($newPaths)) {
                if ($replaceMode) {
                    // Replace: delete old photos first
                    foreach ((array) $gallery->photos as $old) {
                        if ($old) \Illuminate\Support\Facades\Storage::disk('public')->delete($old);
                    }
                }
                // Merge or replace
                if ($replaceMode) {
                    $data['photos'] = $newPaths;
                } else {
                    $data['photos'] = array_merge((array) $gallery->photos, $newPaths);
                }
            }
        }
        // If no new photo uploaded → old photos stay intact (nothing to do)

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Momen berhasil diperbarui!');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->cover_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($gallery->cover_image);
        }
        foreach ((array) $gallery->photos as $photo) {
            if ($photo) \Illuminate\Support\Facades\Storage::disk('public')->delete($photo);
        }
        $gallery->delete();
        return redirect()->route('admin.gallery.index')
            ->with('success', 'Momen berhasil dihapus!');
    }

    public function togglePublish(Gallery $gallery)
    {
        $gallery->update(['is_published' => !$gallery->is_published]);
        return redirect()->back()
            ->with('success', 'Status publish berhasil diubah!');
    }

    public function removePhoto(Request $request, Gallery $gallery)
    {
        $photoPath = $request->input('photo_path');
        $photos = (array) $gallery->photos;
        $photos = array_values(array_filter($photos, fn($p) => $p !== $photoPath));

        if ($photoPath) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($photoPath);
        }

        $gallery->update(['photos' => $photos]);

        return redirect()->back()->with('success', 'Foto berhasil dihapus!');
    }

    // ─── Categories ─────────────────────────────────────────────────

    public function categoryIndex()
    {
        $categories = GalleryCategory::withCount('galleries')->sorted()->get();
        return view('admin.gallery.category', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($request->name);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = true;

        GalleryCategory::create($validated);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function categoryUpdate(Request $request, GalleryCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active');
        $category->update($validated);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function categoryDestroy(GalleryCategory $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}