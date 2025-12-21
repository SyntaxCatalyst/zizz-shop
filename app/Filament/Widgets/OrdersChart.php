<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Pesanan 7 Hari Terakhir';

    protected static ?int $sort = 2; // Urutan widget di dashboard

    protected static ?string $pollingInterval = '15s'; // Akan refresh setiap 15 detik

    protected function getData(): array
    {
        $data = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $labels = $data->map(fn ($item) => Carbon::parse($item->date)->format('d M'));
        $values = $data->map(fn ($item) => $item->count);

        return [
            'datasets' => [
                [
                    'label' => 'Pesanan Masuk',
                    'data' => $values,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe grafik
    }
}
