<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider; // <-- PENTING: Gunakan Model Setting baru kita, bukan GeneralSettings

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Directive @admin Anda sudah benar, biarkan saja.
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role === 'admin';
        });

        // Cek dulu jika tabelnya ada, untuk menghindari error saat migrasi
        if (Schema::hasTable('settings')) {
            try {
                // Ambil data settings dari Model Setting, dan simpan di Cache
                $settings = Cache::rememberForever('settings', function () {
                    // Ambil baris pertama, atau buat baris kosong baru jika tabelnya kosong
                    return Setting::firstOrCreate([]);
                });

                // Bagikan variabel $settings ke semua view
                View::share('settings', $settings);
            } catch (\Exception $e) {
                // Abaikan error jika terjadi masalah saat booting awal
            }
        }
    }
}
