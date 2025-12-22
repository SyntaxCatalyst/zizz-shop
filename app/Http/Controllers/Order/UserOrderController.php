<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for handling user order views and details.
 */
class UserOrderController extends Controller
{
    /**
     * Display all orders for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display panel details for a specific order.
     *
     * @return \Illuminate\View\View
     */
    public function showPanelDetails(Order $order)
    {
        if ((int)$order->user_id !== (int)Auth::id()) {
            abort(403);
        }

        return view('orders.panel-details', compact('order'));
    }
}
