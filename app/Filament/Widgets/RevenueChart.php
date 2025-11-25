<?php

namespace App\Filament\Widgets;

use App\Models\Orders;
use Illuminate\Support\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan Per Bulan';
    protected static string $color = 'success';
    protected int|string|array $columnSpan = 2;

    public static function canView(): bool
    {
        $user = auth()->user();
        if (! $user) return false;
        if ($user->hasRole('super_admin')) return true;

        $widgetName = \Illuminate\Support\Str::of(static::class)->classBasename();

        $permissions = [
            "widget_{$widgetName}",
            "view_widget_{$widgetName}", // untuk jaga-jaga
        ];

        return $user->canAny($permissions);
    }


    protected function getData(): array
    {
        $revenues = Orders::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(gross) as gross')
        )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('gross', 'month')
            ->toArray();

        $labels = [];
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->translatedFormat('M');
            $data[] = $revenues[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label'     => 'Pendapatan',
                    'data'      => $data,
                    'fill'      => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
