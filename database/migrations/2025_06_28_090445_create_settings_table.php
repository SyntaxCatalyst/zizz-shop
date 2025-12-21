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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('okeconnect_merchant_id')->nullable();
            $table->string('okeconnect_api_key')->nullable();
            $table->text('qris_generator_codeqr')->nullable();
            $table->string('support_whatsapp_number')->nullable();
            $table->string('support_email')->nullable();
            $table->string('support_instagram_url')->nullable();
            $table->string('support_facebook_url')->nullable();
            $table->text('receipt_footer_text')->nullable();
            $table->text('whatsapp_order_template')->nullable();
            $table->string('pterodactyl_domain')->nullable();
            $table->string('pterodactyl_api_key')->nullable(); // Ini adalah API Key Application (ptla_)
            $table->string('pterodactyl_egg_id')->nullable();
            $table->string('pterodactyl_nest_id')->nullable();
            $table->string('pterodactyl_location_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
