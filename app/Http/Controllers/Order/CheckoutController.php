<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\PterodactylService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Controller for handling checkout and payment processes.
 */
class CheckoutController extends Controller
{
    protected OrderService $orderService;

    protected PaymentService $paymentService;

    protected PterodactylService $pterodactylService;

    public function __construct(
        OrderService $orderService,
        PaymentService $paymentService,
        PterodactylService $pterodactylService
    ) {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
        $this->pterodactylService = $pterodactylService;
    }

    /**
     * Process checkout and create order from cart.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Request $request)
    {
        if ($this->orderService->isCartEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        try {
            $totalAmount = $this->orderService->getCartTotal();
            $paymentData = $this->paymentService->createDeposit($totalAmount, 'ewallet', 'qris');
            $order = $this->orderService->createOrderFromCart(Auth::id(), $paymentData);

            return redirect()->route('checkout.payment', $order);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat kode QRIS, silakan coba lagi.');
        }
    }

    /**
     * Show payment page for an order.
     *
     * @return \Illuminate\View\View
     */
    public function showPayment(Order $order)
    {
        // DEBUG LOGGING START
        Log::info('Debug Payment Auth:', [
            'order_id' => $order->id,
            'order_user_id' => $order->user_id,
            'order_user_id_type' => gettype($order->user_id),
            'auth_id' => Auth::id(),
            'auth_id_type' => gettype(Auth::id()),
            'match' => $order->user_id === Auth::id()
        ]);
        // DEBUG LOGGING END

        if ((int)$order->user_id !== (int)Auth::id()) { // Temporary type-safe comparison
             Log::warning('Payment Access Denied due to mismatch');
             abort(403, 'Unauthorized: Order ID ' . $order->user_id . ' vs Auth ID ' . Auth::id());
        }

        $settings = Setting::first();

        return view('checkout.payment', compact('order', 'settings'));
    }

    /**
     * Check payment status for an order.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStatus(Order $order)
    {
        $settings = Setting::first();

        if ((int)$order->user_id !== (int)Auth::id()) {
            return response()->json(['status' => 'unauthorized'], 403);
        }

        if (in_array($order->status, ['pending', 'processing'])) {
             // Check status upstream if pending
            if ($order->status === 'pending' && isset($order->payment_details['id'])) {
                try {
                    $paymentStatus = $this->paymentService->checkStatus($order->payment_details['id']);
                    
                    if (isset($paymentStatus['status']) && in_array($paymentStatus['status'], ['success', 'processing'])) {
                        $this->orderService->updateOrderStatus($order, 'processing');
                        $order->refresh(); // Refresh to get updated status
                    }
                } catch (\Exception $e) {
                    Log::error('Check Payment Status Error: ' . $e->getMessage());
                }
            }

            if ($order->status === 'pending') {
                 return response()->json(['status' => 'pending']);
            }
        }

        if (in_array($order->status, ['processing'])) {
            $paymentDetails = $order->payment_details;

            // Handle Pterodactyl order - create server if needed
            if (
                isset($paymentDetails['metadata']['is_pterodactyl_order']) &&
                $paymentDetails['metadata']['is_pterodactyl_order'] &&
                ! isset($paymentDetails['server_details'])
            ) {
                return $this->handlePterodactylServerCreation($order, $paymentDetails);
            }

            // Handle regular product order - send WhatsApp notification
            return $this->handleRegularOrderCompletion($order, $settings);
        }

        return response()->json(['status' => $order->status]);
    }

    /**
     * Handle Pterodactyl server creation for paid orders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handlePterodactylServerCreation(Order $order, array $paymentDetails)
    {
        try {
            $generatedEmail = \Str::slug($order->user->name, '.').'@zizzmarket.my.id';

            $serverDetails = $this->pterodactylService->createServer(
                $paymentDetails['metadata'],
                $generatedEmail,
                $order->user->id
            );

            $newPaymentDetails = array_merge($paymentDetails, ['server_details' => $serverDetails]);

            $this->orderService->updatePaymentDetails($order, $newPaymentDetails);
            $this->orderService->updateOrderStatus($order, 'completed');

            return response()->json([
                'status' => 'paid',
                'redirect_url' => route('orders.panel-details', $order),
            ]);
        } catch (\Exception $e) {
            Log::error('Pterodactyl Creation Failed: '.$e->getMessage());
            $this->orderService->updateOrderStatus($order, 'failed');

            return response()->json([
                'status' => 'paid',
                'redirect_url' => route('orders.index').'?error=ptero_failed',
            ]);
        }
    }

    /**
     * Handle regular order completion with WhatsApp notification.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleRegularOrderCompletion(Order $order, Setting $settings)
    {
        $template = $settings->whatsapp_order_template ?? "Halo {nama_penerima}!\n\nTerima kasih atas pembayaran Anda.\n\n*Detail Pesanan:*\n🧾 *Nomor Order:* {order_number}\n\n{detail_pesanan}\n💳 *Total Pembayaran:* {total_pembayaran}\n\nPesanan Anda sedang diproses. Terima kasih!";

        $recipientName = $order->user->name ?? 'Customer';
        $totalPembayaran = $this->paymentService->formatCurrency($order->total_amount);
        $orderNumber = $order->order_number;

        $detailPesananText = '';
        foreach ($order->items as $item) {
            $hargaProduk = $this->paymentService->formatCurrency($item->price);
            $detailPesananText .= "📦 *Produk:* {$item->product->name}\n".
                                  "🔢 *Jumlah:* {$item->quantity}\n".
                                  "💰 *Harga Satuan:* {$hargaProduk}\n".
                                  "────────────────────────\n";
        }

        $finalMessage = str_replace(
            ['{nama_penerima}', '{detail_pesanan}', '{total_pembayaran}', '{order_number}'],
            [$recipientName, $detailPesananText, $totalPembayaran, $orderNumber],
            $template
        );

        $cleanPhoneNumber = preg_replace('/[^0-9]/', '', $settings->support_whatsapp_number);
        if (substr($cleanPhoneNumber, 0, 1) === '0') {
            $cleanPhoneNumber = '62'.substr($cleanPhoneNumber, 1);
        } elseif (substr($cleanPhoneNumber, 0, 2) !== '62') {
            $cleanPhoneNumber = '62'.$cleanPhoneNumber;
        }

        $waUrl = "https://api.whatsapp.com/send?phone={$cleanPhoneNumber}&text=".urlencode($finalMessage);

        $this->orderService->updateOrderStatus($order, 'completed');

        return response()->json(['status' => 'paid', 'redirect_url' => $waUrl]);
    }

    /**
     * Cancel a pending order.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelOrder(Order $order)
    {
        if ((int)$order->user_id !== (int)Auth::id()) {
            abort(403);
        }

        if ($order->status === 'pending') {
            $this->orderService->updateOrderStatus($order, 'canceled');

            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->route('orders.index')->with('error', 'Pesanan ini tidak dapat dibatalkan.');
    }
}
