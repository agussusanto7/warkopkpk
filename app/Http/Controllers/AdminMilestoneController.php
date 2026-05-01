<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use Illuminate\Http\Request;

class AdminMilestoneController extends Controller
{
    public function index()
    {
        $milestones = Milestone::orderBy('year')->get();
        return view('admin.milestone.index', compact('milestones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        Milestone::create($validated);

        return redirect()->back()->with('success', 'Milestone berhasil ditambahkan!');
    }

    public function update(Request $request, Milestone $milestone)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $milestone->update($validated);

        return redirect()->back()->with('success', 'Milestone berhasil diperbarui!');
    }

    public function destroy(Milestone $milestone)
    {
        $milestone->delete();
        return redirect()->back()->with('success', 'Milestone berhasil dihapus!');
    }
}
