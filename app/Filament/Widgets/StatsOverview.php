<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User; // <-- Import model Order
use Filament\Widgets\StatsOverviewWidget as BaseWidget; // <-- Import model Product
use Filament\Widgets\StatsOverviewWidget\Stat; // <-- Import model User

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count())
                ->description('Jumlah semua produk di toko')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('success'),

            Stat::make('Total Orders', Order::count())
                ->description('Jumlah semua pesanan yang masuk')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            Stat::make('Total Users', User::where('role', 'user')->count())
                ->description('Jumlah semua pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}
