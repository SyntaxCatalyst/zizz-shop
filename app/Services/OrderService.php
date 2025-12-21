<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PterodactylPlan;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;

/**
 * Service class for handling order operations.
 * Centralizes order creation and management logic.
 */
class OrderService
{
    /**
     * Create an order from the shopping cart.
     *
     * @param  int  $userId  The user ID who is placing the order
     * @param  array  $paymentData  The payment details from payment API
     * @return Order The created order instance
     */
    public function createOrderFromCart(int $userId, array $paymentData): Order
    {
        $totalAmount = (int) Cart::total(0, '', '');

        $order = Order::create([
            'user_id' => $userId,
            'order_number' => $this->generateOrderNumber('INV'),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_details' => $paymentData,
        ]);

        // Create order items from cart
        foreach (Cart::content() as $item) {
            $order->items()->create([
                'product_id' => $item->id,
                'quantity' => $item->qty,
                'price' => $item->price,
            ]);
        }

        // Clear the cart after order creation
        Cart::destroy();

        return $order;
    }

    /**
     * Create a Pterodactyl panel order.
     *
     * @param  int  $userId  The user ID who is placing the order
     * @param  PterodactylPlan  $plan  The selected pterodactyl plan
     * @param  array  $metadata  Order metadata (username, plan details, etc.)
     * @param  array  $paymentData  The payment details from payment API
     * @return Order The created order instance
     */
    public function createPterodactylOrder(
        int $userId,
        PterodactylPlan $plan,
        array $metadata,
        array $paymentData
    ): Order {
        // Add unique fee for unique payment amount
        $uniqueFee = rand(0, 500);
        $totalAmount = $plan->price + $uniqueFee;

        // Add unique fee to metadata
        $metadata['unique_fee'] = $uniqueFee;

        // Add metadata to payment data
        $paymentData['metadata'] = $metadata;

        $order = Order::create([
            'user_id' => $userId,
            'order_number' => $this->generateOrderNumber('PNL'),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_details' => $paymentData,
        ]);

        return $order;
    }

    /**
     * Generate a unique order number.
     *
     * @param  string  $prefix  The prefix for the order number (e.g., 'INV' or 'PNL')
     * @return string The generated order number
     */
    public function generateOrderNumber(string $prefix = 'INV'): string
    {
        return $prefix.'-'.strtoupper(Str::random(8));
    }

    /**
     * Calculate cart total.
     *
     * @return int The total amount in IDR
     */
    public function getCartTotal(): int
    {
        return (int) Cart::total(0, '', '');
    }

    /**
     * Check if cart is empty.
     */
    public function isCartEmpty(): bool
    {
        return Cart::count() == 0;
    }

    /**
     * Update order payment details.
     */
    public function updatePaymentDetails(Order $order, array $newPaymentDetails): bool
    {
        return $order->update([
            'payment_details' => $newPaymentDetails,
        ]);
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Order $order, string $status): bool
    {
        return $order->update([
            'status' => $status,
        ]);
    }
}
