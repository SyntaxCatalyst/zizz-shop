<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Mengubah kolom image_url agar BOLEH diisi null
            $table->string('image_url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Kode untuk mengembalikan jika di-rollback
            $table->string('image_url')->nullable(false)->change();
        });
    }
};