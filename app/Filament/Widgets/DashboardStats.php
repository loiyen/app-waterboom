<?php

namespace App\Filament\Widgets;

use App\Models\Orders;
use App\Models\Customers;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class DashboardStats extends BaseWidget
{

    protected static ?string $pollingInterval = '10s';

    public static function canView(): bool
    {
        $user = auth()->user();

        if (! $user) return false;
        if ($user->hasRole('super_admin')) return true;

        $widgetName = Str::of(static::class)->classBasename();

        $permissions = [
            "widget_{$widgetName}",
            "view_widget_{$widgetName}", 
        ];

        return $user->canAny($permissions);
    }

    protected function getStats(): array
    {

        $todayRevenue = Orders::whereDate('created_at', Carbon::today())
            ->sum('gross');

        $totalCustomers = Customers::count();

        $activeOrders = Orders::where('payment_status', 'unpaid')->count();

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->description('Total transaksi masuk hari ini')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Total Pelanggan', number_format($totalCustomers))
                ->description('Pelanggan terdaftar')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Order Aktif', number_format($activeOrders))
                ->description('Masih dalam proses')
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color('warning'),
        ];
    }
}
