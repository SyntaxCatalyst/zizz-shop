<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

/**
 * Controller for the user dashboard page.
 */
class DashboardController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display the dashboard page with products and plans.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = $this->productService->getLatestProducts();
        $pterodactylPlans = $this->productService->getAllPterodactylPlans();
        
        // User Stats
        $user = auth()->user();
        $stats = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'total_spent' => $user->orders()->where('status', 'paid')->sum('total_amount'), // Assuming 'paid' or 'completed' status
        ];

        return view('dashboard', compact('products', 'pterodactylPlans', 'stats'));
    }
}
