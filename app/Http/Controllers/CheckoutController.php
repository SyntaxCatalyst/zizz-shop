<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $settings = Setting::first();
        // dd('Mulai proses checkout...');
        if (Cart::count() == 0) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        $totalAmount = (int) Cart::total(0, '', ''); // Ambil total sebagai integer tanpa format

        // Panggil API Generate QRIS
        $response = Http::get('https://cloud-rest-api-tau.vercel.app/api/orkut/createpayment', [
            'apikey' => 'mahiru', // Sesuai contoh, bisa diganti nanti jika perlu
            'amount' => $totalAmount,
            'codeqr' => $settings->qris_generator_codeqr,
        ]);


        if ($response->failed() || !$response->json('status')) {
            return back()->with('error', 'Gagal membuat kode QRIS, silakan coba lagi.');
        }

        $paymentData = $response->json('result');

        // Simpan order ke database
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'INV-' . strtoupper(Str::random(8)),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_details' => $paymentData, // Simpan semua response dari API
        ]);

        // Simpan item-item order
        foreach (Cart::content() as $item) {
            $order->items()->create([
                'product_id' => $item->id,
                'quantity' => $item->qty,
                'price' => $item->price,
            ]);
        }

        // Hapus keranjang setelah order dibuat
        Cart::destroy();

        // Arahkan ke halaman pembayaran
        return redirect()->route('checkout.payment', $order);
    }

    public function showPayment(Order $order)
    {
        // Pastikan pengguna hanya bisa melihat order miliknya
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.payment', compact('order'));
    }

    public function checkStatus(Order $order)
    {
        $settings = Setting::first();
        if ($order->user_id !== Auth::id()) {
            return response()->json(['status' => 'unauthorized'], 403);
        }

        if ($order->status !== 'pending') {
            return response()->json(['status' => 'paid', 'redirect_url' => route('orders.index')]);
        }

        $response = Http::get("https://gateway.okeconnect.com/api/mutasi/qris/{$settings->okeconnect_merchant_id}/{$settings->okeconnect_api_key}");

        if ($response->failed() || $response->json('status') !== 'success') {
            return response()->json(['status' => 'pending']);
        }

        $mutations = $response->json('data');
        $paymentFound = false;

        foreach ($mutations as $mutation) {
            $mutationTime = \Carbon\Carbon::parse($mutation['date']);
            if ((int)$mutation['amount'] === (int)$order->total_amount && $mutationTime->isAfter($order->created_at->subMinutes(1))) {
                $paymentFound = true;
                break;
            }
        }

        if ($paymentFound) {
            $order->update(['status' => 'processing']);

            // Cek apakah ini order Pterodactyl
    $paymentDetails = $order->payment_details;
    if (isset($paymentDetails['metadata']['is_pterodactyl_order']) && $paymentDetails['metadata']['is_pterodactyl_order']) {
        try {
            // Panggil Pterodactyl Service untuk membuat server
            $pterodactylService = new \App\Services\PterodactylService();
            
            $serverDetails = $pterodactylService->createServer($paymentDetails['metadata'], $order->user->email, $order->user->id);

            // Update order dengan detail server & set status completed
            $newPaymentDetails = array_merge($paymentDetails, ['server_details' => $serverDetails]);
            $order->update([
                'status' => 'completed',
                'payment_details' => $newPaymentDetails,
            ]);

            // Siapkan URL redirect ke halaman detail panel
            $redirectUrl = route('orders.panel-details', $order);

            // Kirim respon untuk redirect ke halaman detail panel
            return response()->json(['status' => 'paid', 'redirect_url' => $redirectUrl]);

        } catch (\Exception $e) {
            // Jika pembuatan panel gagal, update status order menjadi 'failed'
            $order->update(['status' => 'failed']);
            \Illuminate\Support\Facades\Log::error('Pterodactyl Creation Failed: ' . $e->getMessage());

            // Redirect ke halaman riwayat order dengan pesan error
            return response()->json(['status' => 'paid', 'redirect_url' => route('orders.index') . '?error=ptero_failed']);
        }
    }

            // --- AWAL BLOK KODE BARU UNTUK PESAN WA ---

            // Ambil template dari database settings
            $template = $settings->whatsapp_order_template;

            // Siapkan data-data dinamis
            $recipientName = $order->user->name ?? 'Customer';
            $totalPembayaran = 'Rp ' . number_format($order->total_amount, 0, ',', '.');
            $orderNumber = $order->order_number;

            // Buat bagian detail pesanan secara terpisah (karena ada loop)
            $detailPesananText = '';
            foreach ($order->items as $item) {
                $hargaProduk = 'Rp ' . number_format($item->price, 0, ',', '.');
                $detailPesananText .= "📦 *Produk:* {$item->product->name}\n" .
                                      "🔢 *Jumlah:* {$item->quantity}\n" .
                                      "💰 *Harga Satuan:* {$hargaProduk}\n" .
                                      "────────────────────────\n";
            }

            // Cek apakah template ada dan tidak kosong
            if (empty($template)) {
                // Jika template kosong, buat default template
                $template = "Halo {nama_penerima}!\n\n" .
                           "Terima kasih atas pembayaran Anda.\n\n" .
                           "*Detail Pesanan:*\n" .
                           "🧾 *Nomor Order:* {order_number}\n\n" .
                           "{detail_pesanan}\n" .
                           "💳 *Total Pembayaran:* {total_pembayaran}\n\n" .
                           "Pesanan Anda sedang diproses. Terima kasih!";
            }

            // Definisikan placeholder dan nilainya
            $placeholders = [
                '{nama_penerima}',
                '{detail_pesanan}',
                '{total_pembayaran}',
                '{order_number}',
            ];
            $values = [
                $recipientName,
                $detailPesananText,
                $totalPembayaran,
                $orderNumber,
            ];

            // Ganti semua placeholder di template dengan nilai sebenarnya
            $finalMessage = str_replace($placeholders, $values, $template);

            // Bersihkan nomor WhatsApp dari spasi dan karakter tidak valid
            $cleanPhoneNumber = preg_replace('/[^0-9]/', '', $settings->support_whatsapp_number);
            
            // Pastikan nomor diawali dengan 62 (untuk Indonesia)
            if (substr($cleanPhoneNumber, 0, 1) === '0') {
                $cleanPhoneNumber = '62' . substr($cleanPhoneNumber, 1);
            } elseif (substr($cleanPhoneNumber, 0, 2) !== '62') {
                $cleanPhoneNumber = '62' . $cleanPhoneNumber;
            }

            // Jika pesan masih kosong, buat pesan sederhana
            if (empty($finalMessage) || strlen(trim($finalMessage)) === 0) {
                $finalMessage = "Halo {$recipientName}!\n\nPembayaran untuk order {$orderNumber} sebesar {$totalPembayaran} telah diterima.\n\nTerima kasih!";
            }

            // Debug: Log untuk troubleshooting (opsional, bisa dihapus di production)
            \Log::info('WhatsApp Debug Info:', [
                'original_template' => $settings->whatsapp_order_template,
                'final_message' => $finalMessage,
                'phone_number' => $cleanPhoneNumber,
                'message_length' => strlen($finalMessage)
            ]);

            // Buat URL WhatsApp
            $waUrl = "https://api.whatsapp.com/send?phone={$cleanPhoneNumber}&text=" . urlencode($finalMessage);
            
            // --- AKHIR BLOK KODE BARU ---

            return response()->json(['status' => 'paid', 'redirect_url' => $waUrl]);
        }
        
        return response()->json(['status' => 'pending']);
    }
}