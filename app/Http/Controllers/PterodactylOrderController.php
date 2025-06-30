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

        // Siapkan metadata untuk disimpan di order
        $metadata = [
            'is_pterodactyl_order' => true,
            'plan_name' => $plan->name,
            'ram' => $plan->ram,
            'disk' => $plan->disk,
            'cpu' => $plan->cpu,
            'panel_username' => $request->panel_username,
        ];

        // Panggil API Generate QRIS
        $response = Http::get('https://cloud-rest-api-tau.vercel.app/api/orkut/createpayment', [
            'apikey' => 'mahiru',
            'amount' => (int) $plan->price,
            'codeqr' => $settings->qris_generator_codeqr,
        ]);

        if ($response->failed() || !$response->json('status')) {
            return back()->with('error', 'Gagal membuat kode QRIS, silakan coba lagi.');
        }

        $paymentData = $response->json('result');
        $paymentData['metadata'] = $metadata; // Selipkan metadata kita ke data pembayaran

        // Simpan order ke database
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'PNL-' . strtoupper(Str::random(8)),
            'total_amount' => $plan->price,
            'status' => 'pending',
            'payment_details' => $paymentData, // Simpan semua response, termasuk metadata kita
        ]);
        
        // Untuk order Pterodactyl, kita tidak membuat order_items
        
        // Arahkan ke halaman pembayaran
        return redirect()->route('checkout.payment', $order);
    }
}