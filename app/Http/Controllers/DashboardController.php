<?php

namespace App\Http\Controllers;

use App\Models\Product; // <-- Jangan lupa use model
use Illuminate\Http\Request;
use App\Models\PterodactylPlan;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data produk
        $products = Product::latest()->get();

        $pterodactylPlans = PterodactylPlan::all();

        // Tampilkan view 'dashboard' dan kirim data produk
        return view('dashboard', compact('products', 'pterodactylPlans'));
    }
}