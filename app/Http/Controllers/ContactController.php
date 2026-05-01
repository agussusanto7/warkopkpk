<?php

namespace App\Http\Controllers;

use App\Models\FeedbackPelanggan;
use App\Models\SiteImage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contactHeaderImage = SiteImage::getImage('contact_header');

        // Get contact info from database
        $contactInfo = [
            'address' => SiteSetting::getValue('address', 'Jl. Kopi Nusantara No. 88, Jakarta Selatan 12345'),
            'phone' => SiteSetting::getValue('phone', '+62 812-3456-7890'),
            'email' => SiteSetting::getValue('email', 'hello@warkopkpk.com'),
            'whatsapp' => SiteSetting::getValue('whatsapp', '6281234567890'),
            'jam_buka' => SiteSetting::getValue('jam_buka', 'Senin - Jumat: 08:00 - 23:00'),
            'maps_url' => SiteSetting::getValue('maps_url', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d303.74258107952653!2d112.3518165!3d-8.1403326!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78968a0294879d%3A0x8f5867007101682e!2sWarkop%20Cethe%20KPK!5e1!3m2!1sid!2sid!4v1777608801115!5m2!1sid!2sid'),
        ];

        return view('contact', compact('contactHeaderImage', 'contactInfo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
        ]);

        FeedbackPelanggan::create($validated);

        return redirect()->route('contact')->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
}
