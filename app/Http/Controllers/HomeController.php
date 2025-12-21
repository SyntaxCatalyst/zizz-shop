<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

/**
 * Controller for the home/welcome page.
 */
class HomeController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display the home page with products and statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = $this->productService->getAllProductsWithCategory();
        $statistics = $this->productService->getProductStatistics();
        $pterodactylPlans = $this->productService->getAllPterodactylPlans();

        return view('welcome', [
            'products' => $products,
            'totalUsers' => $statistics['total_users'],
            'totalProducts' => $statistics['total_products'],
            'pterodactylPlans' => $pterodactylPlans,
        ]);
    }
}
