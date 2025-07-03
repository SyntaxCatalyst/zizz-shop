<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PterodactylPlan;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PterodactylOrderController extends Controller
{
    // Method untuk menampilkan halaman pilihan paket
    public function index()
    {
        $plans = PterodactylPlan::all();
        return view('pterodactyl.order-form', compact('plans'));
    }

    // Method untuk memproses pesanan sebelum ke pembayaran
    public function processOrder(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:pterodactyl_plans,id',
            'panel_username' => 'required|string|alpha_dash|max:191', // Validasi username
        ]);

        $settings = Setting::first();
        $plan = PterodactylPlan::find($request->plan_id);

        // --- AWAL PERUBAHAN ---
        // Menambahkan fee acak untuk membuat total pembayaran unik
        $unique_fee = rand(0, 500);
        $totalAmount = $plan->price + $unique_fee;
        // --- AKHIR PERUBAHAN ---

        // Siapkan metadata untuk disimpan di order
        $metadata = [
            'is_pterodactyl_order' => true,
            'plan_name' => $plan->name,
            'ram' => $plan->ram,
            'disk' => $plan->disk,
            'cpu' => $plan->cpu,
            'panel_username' => $request->panel_username,
            'unique_fee' => $unique_fee, // Simpan fee untuk referensi
        ];

        // Panggil API Generate QRIS dengan total yang sudah ditambahkan fee
        $response = Http::get('https://cloud-rest-api-tau.vercel.app/api/orkut/createpayment', [
            'apikey' => 'mahiru',
            'amount' => (int) $totalAmount,
            'codeqr' => $settings->qris_generator_codeqr,
        ]);

        if ($response->failed() || !$response->json('status')) {
            return back()->with('error', 'Gagal membuat kode QRIS, silakan coba lagi.');
        }

        $paymentData = $response->json('result');
        $paymentData['metadata'] = $metadata; // Selipkan metadata kita ke data pembayaran

        // Simpan order ke database dengan total yang baru
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'PNL-' . strtoupper(Str::random(8)),
            'total_amount' => $totalAmount, // Gunakan total_amount yang baru
            'status' => 'pending',
            'payment_details' => $paymentData,
        ]);
        
        // Arahkan ke halaman pembayaran
        return redirect()->route('checkout.payment', $order);
    }
}