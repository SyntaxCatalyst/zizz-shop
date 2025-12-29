<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CancelExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-expired-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel orders that have been pending for more than 10 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where('status', 'pending')
                       ->where('created_at', '<', now()->subMinutes(10))
                       ->get();

        $count = $orders->count();

        if ($count > 0) {
            foreach ($orders as $order) {
                // You might want to release stock here if applicable
                // Or inform the user via email
                
                $order->update(['status' => 'cancelled']);
                Log::info("Order #{$order->order_number} auto-cancelled due to timeout.");
            }
            
            $this->info("Cancelled {$count} expired orders.");
        } else {
            $this->info("No expired orders found.");
        }
    }
}
