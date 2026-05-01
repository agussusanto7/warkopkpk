<?php

namespace App\Http\Controllers;

use App\Models\FeedbackPelanggan;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = FeedbackPelanggan::orderByDesc('created_at')->get();
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function markAsRead(FeedbackPelanggan $feedback)
    {
        $feedback->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Feedback ditandai sudah dibaca');
    }

    public function destroy(FeedbackPelanggan $feedback)
    {
        $feedback->delete();
        return redirect()->route('admin.feedback.index')->with('success', 'Feedback berhasil dihapus');
    }
}