<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('order_number')->unique();
    $table->decimal('total_amount', 15, 2);
    $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'canceled'])->default('pending');
    $table->json('payment_details')->nullable(); // Untuk menyimpan info dari API QRIS
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
