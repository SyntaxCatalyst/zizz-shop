<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {
        // Mengambil order milik user yang login dan membaginya per halaman (10 order per halaman)
        $orders = Auth::user()->orders()->latest()->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    public function showPanelDetails(Order $order)
    {
        if ($order->user_id !== Auth::id() || $order->status !== 'completed') {
            abort(403, 'Akses Ditolak');
        }

        $serverDetails = $order->payment_details['server_details'] ?? null;
        $settings = \App\Models\Setting::first();

        if (!$serverDetails) {
            return redirect()->route('orders.index')->with('error', 'Detail panel tidak ditemukan.');
        }
        
        return view('orders.panel-details', compact('order', 'serverDetails', 'settings'));
    }
}