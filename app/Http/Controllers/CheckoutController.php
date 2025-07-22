<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Services\PterodactylService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $settings = Setting::first();

        if (Cart::count() == 0) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        $totalAmount = (int) Cart::total(0, '', '');

        $response = Http::get('https://cloud-rest-api-tau.vercel.app/api/orkut/createpayment', [
            'apikey' => 'mahiru',
            'amount' => $totalAmount,
            'codeqr' => $settings->qris_generator_codeqr,
        ]);

        if ($response->failed() || !$response->json('status')) {
            return back()->with('error', 'Gagal membuat kode QRIS, silakan coba lagi.');
        }

        $paymentData = $response->json('result');

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'INV-' . strtoupper(Str::random(8)),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_details' => $paymentData,
        ]);

        foreach (Cart::content() as $item) {
            $order->items()->create([
                'product_id' => $item->id,
                'quantity' => $item->qty,
                'price' => $item->price,
            ]);
        }

        Cart::destroy();

        return redirect()->route('checkout.payment', $order);
    }

    public function showPayment(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $settings = Setting::first();
        return view('checkout.payment', compact('order', 'settings'));
    }

    public function checkStatus(Order $order)
    {
        $settings = Setting::first();

        if ($order->user_id !== Auth::id()) {
            return response()->json(['status' => 'unauthorized'], 403);
        }

        if ($order->status === 'pending') {
            return response()->json(['status' => 'pending']);
        }

        if (in_array($order->status, ['processing'])) {
            $paymentDetails = $order->payment_details;

            if (
                isset($paymentDetails['metadata']['is_pterodactyl_order']) &&
                $paymentDetails['metadata']['is_pterodactyl_order'] &&
                !isset($paymentDetails['server_details'])
            ) {
                try {
                    $pterodactylService = new PterodactylService();
                    $generatedEmail = Str::slug($order->user->name, '.') . '@zizzmarket.my.id';

$serverDetails = $pterodactylService->createServer(
    $paymentDetails['metadata'],
    $generatedEmail,
    $order->user->id
);

                    $newPaymentDetails = array_merge($paymentDetails, ['server_details' => $serverDetails]);

                    $order->update([
                        'status' => 'completed',
                        'payment_details' => $newPaymentDetails,
                    ]);

                    return response()->json([
                        'status' => 'paid',
                        'redirect_url' => route('orders.panel-details', $order)
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Pterodactyl Creation Failed: ' . $e->getMessage());
                    $order->update(['status' => 'failed']);

                    return response()->json([
                        'status' => 'paid',
                        'redirect_url' => route('orders.index') . '?error=ptero_failed'
                    ]);
                }
            }

            $template = $settings->whatsapp_order_template ?? "Halo {nama_penerima}!\n\nTerima kasih atas pembayaran Anda.\n\n*Detail Pesanan:*\n🧾 *Nomor Order:* {order_number}\n\n{detail_pesanan}\n💳 *Total Pembayaran:* {total_pembayaran}\n\nPesanan Anda sedang diproses. Terima kasih!";

            $recipientName = $order->user->name ?? 'Customer';
            $totalPembayaran = 'Rp ' . number_format($order->total_amount, 0, ',', '.');
            $orderNumber = $order->order_number;

            $detailPesananText = '';
            foreach ($order->items as $item) {
                $hargaProduk = 'Rp ' . number_format($item->price, 0, ',', '.');
                $detailPesananText .= "📦 *Produk:* {$item->product->name}\n" .
                                      "🔢 *Jumlah:* {$item->quantity}\n" .
                                      "💰 *Harga Satuan:* {$hargaProduk}\n" .
                                      "────────────────────────\n";
            }

            $finalMessage = str_replace(
                ['{nama_penerima}', '{detail_pesanan}', '{total_pembayaran}', '{order_number}'],
                [$recipientName, $detailPesananText, $totalPembayaran, $orderNumber],
                $template
            );

            $cleanPhoneNumber = preg_replace('/[^0-9]/', '', $settings->support_whatsapp_number);
            if (substr($cleanPhoneNumber, 0, 1) === '0') {
                $cleanPhoneNumber = '62' . substr($cleanPhoneNumber, 1);
            } elseif (substr($cleanPhoneNumber, 0, 2) !== '62') {
                $cleanPhoneNumber = '62' . $cleanPhoneNumber;
            }

            $waUrl = "https://api.whatsapp.com/send?phone={$cleanPhoneNumber}&text=" . urlencode($finalMessage);

            $order->update(['status' => 'completed']);

            return response()->json(['status' => 'paid', 'redirect_url' => $waUrl]);
        }

        return response()->json(['status' => $order->status]);
    }

    public function cancelOrder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status === 'pending') {
            $order->update(['status' => 'canceled']);
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->route('orders.index')->with('error', 'Pesanan ini tidak dapat dibatalkan.');
    }
}
