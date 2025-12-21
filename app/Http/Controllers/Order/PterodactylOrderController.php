<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\PterodactylPlan;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for handling Pterodactyl panel orders.
 */
class PterodactylOrderController extends Controller
{
    protected OrderService $orderService;

    protected PaymentService $paymentService;

    public function __construct(OrderService $orderService, PaymentService $paymentService)
    {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }

    /**
     * Display the Pterodactyl plan selection page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $plans = PterodactylPlan::all();

        return view('pterodactyl.order-form', compact('plans'));
    }

    /**
     * Process Pterodactyl order before payment.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processOrder(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:pterodactyl_plans,id',
            'panel_username' => 'required|string|alpha_dash|max:191',
        ]);

        $plan = PterodactylPlan::findOrFail($request->plan_id);

        // Prepare metadata for the order
        $metadata = [
            'is_pterodactyl_order' => true,
            'plan_name' => $plan->name,
            'ram' => $plan->ram,
            'disk' => $plan->disk,
            'cpu' => $plan->cpu,
            'panel_username' => $request->panel_username,
        ];

        try {
            // Add unique fee for unique payment amount
            $uniqueFee = rand(0, 500);
            $totalAmount = $plan->price + $uniqueFee;

            // Create QRIS payment
            $paymentData = $this->paymentService->createDeposit($totalAmount, 'ewallet', 'qris');

            // Add unique fee to metadata
            $metadata['unique_fee'] = $uniqueFee;

            // Create order
            $order = $this->orderService->createPterodactylOrder(
                Auth::id(),
                $plan,
                $metadata,
                $paymentData
            );

            return redirect()->route('checkout.payment', $order);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat kode QRIS, silakan coba lagi.');
        }
    }
}
