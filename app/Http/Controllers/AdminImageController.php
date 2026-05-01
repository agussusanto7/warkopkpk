<?php

namespace App\Http\Controllers;

use App\Models\SiteImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminImageController extends Controller
{
    public function index()
    {
        $images = SiteImage::orderBy('section_key')->orderByDesc('is_active')->get();
        $sections = SiteImage::getSections();
        return view('admin.images.index', compact('images', 'sections'));
    }

    public function create()
    {
        $sections = SiteImage::getSections();
        return view('admin.images.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_key' => 'required|string',
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $path = $request->file('image')->store('site-images', 'public');

        // If setting as active, deactivate others in same section
        if ($request->boolean('is_active')) {
            SiteImage::where('section_key', $validated['section_key'])->update(['is_active' => false]);
        }

        SiteImage::create([
            'section_key' => $validated['section_key'],
            'title' => $validated['title'],
            'image_path' => $path,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.images.index')->with('success', 'Foto berhasil diupload!');
    }

    public function activate(SiteImage $siteImage)
    {
        // Deactivate others in same section
        SiteImage::where('section_key', $siteImage->section_key)->update(['is_active' => false]);
        $siteImage->update(['is_active' => true]);

        return redirect()->route('admin.images.index')->with('success', 'Foto "' . $siteImage->title . '" diaktifkan!');
    }

    public function destroy(SiteImage $siteImage)
    {
        Storage::disk('public')->delete($siteImage->image_path);
        $siteImage->delete();
        return redirect()->route('admin.images.index')->with('success', 'Foto berhasil dihapus!');
    }
}
