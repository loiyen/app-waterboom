<?php

namespace App\Filament\Widgets;

use App\Models\Orders;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class OrderSummary extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    protected function getStats(): array
    {
        $totalOrders = Orders::count();
        $totalPaid = Orders::where('payment_status', 'paid')->sum('gross');
        $unpaidCount = Orders::where('payment_status', 'unpaid')->count();
        $todaySales = Orders::whereDate('created_at', today())->sum('gross');

        return [
            Stat::make('Total Order', number_format($totalOrders))
                ->description('Jumlah semua order')
                ->icon('heroicon-o-shopping-cart'),

            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPaid, 0, ',', '.'))
                ->description('Pembayaran yang sudah lunas')
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Belum Dibayar', number_format($unpaidCount))
                ->description('Order dengan status unpaid')
                ->color('danger')
                ->icon('heroicon-o-clock'),

            Stat::make('Penjualan Hari Ini', 'Rp ' . number_format($todaySales, 0, ',', '.'))
                ->description('Gross hari ini')
                ->color('warning')
                ->icon('heroicon-o-calendar'),
        ];
    }
}
