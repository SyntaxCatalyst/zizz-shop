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
        Schema::create('pterodactyl_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('ram');
            $table->unsignedInteger('disk');
            $table->unsignedInteger('cpu');
            $table->decimal('price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pterodactyl_plans');
    }
};
