<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Produk', Product::where('is_active', true)->count())
                ->description('Produk aktif')
                ->descriptionIcon('heroicon-o-cube')
                ->color('primary'),

            Stat::make('Kategori', Category::where('is_active', true)->count())
                ->description('Kategori aktif')
                ->descriptionIcon('heroicon-o-tag')
                ->color('success'),

            Stat::make('Produk dengan Harga', Product::whereNotNull('price')->count())
                ->description('1 harga per produk (sistem 1 toko)')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('warning'),

            Stat::make('Pesanan', Order::count())
                ->description(Order::where('status', 'pending')->count() . ' menunggu verifikasi')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('danger'),

            Stat::make('Pengguna', User::count())
                ->description(User::where('role', 'buyer')->count() . ' pembeli')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
        ];
    }
}
