<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Models\Message;
use App\Http\Controllers\CartController; 
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PterodactylOrderController;
use App\Http\Controllers\ContactMessageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');

//remove 'verified' ini this middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/order-panel', [PterodactylOrderController::class, 'index'])->name('pterodactyl.order.index');
    Route::post('/order-panel', [PterodactylOrderController::class, 'processOrder'])->name('pterodactyl.order.process');

    
    Route::get('/orders/{order}/panel-details', [UserOrderController::class, 'showPanelDetails'])->name('orders.panel-details');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/status/{order}', [CheckoutController::class, 'checkStatus'])->name('checkout.status');
    Route::post('/checkout/{order}/cancel', [CheckoutController::class, 'cancelOrder'])->name('checkout.cancel');
    Route::get('/orders/{order}/payment', [CheckoutController::class, 'showPayment'])->name('checkout.payment');
    //Route::get('/orders/{order}/status', [CheckoutController::class, 'checkStatus'])->name('checkout.status');
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('orders.index');
    
    Route::post('/messages/read/{message}', function (Message $message) {
    if ($message->user_id === auth()->id()) {
        $message->is_read = true;
        $message->save();
    }
    return back();
})->name('messages.read');
    
    Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{rowId}', [CartController::class, 'update'])->name('update');
    Route::get('/remove/{rowId}', [CartController::class, 'remove'])->name('remove');
});
});




require __DIR__.'/auth.php';
