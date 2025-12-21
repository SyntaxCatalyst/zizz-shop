<?php

namespace App\Services;

use App\Models\Product;
use App\Models\PterodactylPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service class for handling product operations.
 * Centralizes product-related data fetching and statistics.
 */
class ProductService
{
    /**
     * Get all products with their category relationships.
     */
    public function getAllProductsWithCategory(): Collection
    {
        return Product::with('category')->latest()->get();
    }

    /**
     * Get all products ordered by latest.
     */
    public function getLatestProducts(): Collection
    {
        return Product::latest()->get();
    }

    /**
     * Get all pterodactyl plans.
     */
    public function getAllPterodactylPlans(): Collection
    {
        return PterodactylPlan::all();
    }

    /**
     * Get product statistics for homepage.
     *
     * @return array Array with 'total_users' and 'total_products' keys
     */
    public function getProductStatistics(): array
    {
        return [
            'total_users' => User::where('role', 'user')->count(),
            'total_products' => Product::count(),
        ];
    }

    /**
     * Get a product by ID with category.
     */
    public function getProductById(int $productId): ?Product
    {
        return Product::with('category')->find($productId);
    }

    /**
     * Get products by category.
     */
    public function getProductsByCategory(int $categoryId): Collection
    {
        return Product::with('category')
            ->where('category_id', $categoryId)
            ->latest()
            ->get();
    }
}
