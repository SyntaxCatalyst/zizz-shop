<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PterodactylPlan;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua produk dari database, urutkan dari yang terbaru
        $products = Product::with('category')->latest()->get();

        $totalUsers = User::where('role', 'user')->count();

        $totalProducts = Product::count();

        $pterodactylPlans = PterodactylPlan::all();

        // Kirim variabel $products ke view 'welcome'
        return view('welcome', compact('products', 'totalUsers', 'totalProducts', 'pterodactylPlans'));
    }
}