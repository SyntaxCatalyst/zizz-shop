<?php

namespace App\Filament\Pages;

// 1. Gunakan BaseDashboard untuk menghindari konflik nama class
use Filament\Pages\Dashboard as BaseDashboard;

// 2. Sesuaikan path ini jika lokasi widget Anda berbeda (misal: App\Filament\Admin\Widgets)
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\GoToFrontendWidget;
use App\Filament\Widgets\OrdersChart;
use App\Filament\Widgets\LatestOrders;

// 3. Pastikan class Anda 'extends BaseDashboard'
class Dashboard extends BaseDashboard
{
    /**
     * Method ini untuk mendaftarkan widget yang ingin ditampilkan di dashboard.
     *
     * @return array<class-string<\Filament\Widgets\Widget> | \Filament\Widgets\WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [
            // Daftarkan widget statistik yang sudah kita buat
            StatsOverview::class,
            GoToFrontendWidget::class,
            OrdersChart::class,
            LatestOrders::class,
        ];
    }

    /**
     * Method ini untuk mengatur jumlah kolom layout widget.
     *
     * @return int | string | array<string, int | string | null>
     */
    public function getColumns(): int | string | array
    {
        // Atur agar widget ditampilkan dalam 3 kolom
        return 3;
    }
}