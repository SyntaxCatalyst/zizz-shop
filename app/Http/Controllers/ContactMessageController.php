<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Setting; // <-- Import Mailable kita
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // <-- Import Facade Mail

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
            'subject' => 'nullable|string|max:255', // Tambahkan subject jika ada
        ]);

        // 1. Simpan pesan ke database
        ContactMessage::create($validated);

        // 2. Kirim notifikasi email ke owner
        try {
            // Ambil email owner dari settings
            $ownerEmail = Setting::first()->support_email;
            if ($ownerEmail) {
                Mail::to($ownerEmail)->send(new ContactMessageReceived($validated));
            }
        } catch (\Exception $e) {
            // Jika email gagal dikirim, jangan sampai membuat user error.
            // Cukup catat error di log untuk diperbaiki nanti.
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email kontak: '.$e->getMessage());
        }

        return back()->with('success', 'Pesan Anda telah berhasil terkirim!');
    }
}
