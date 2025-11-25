<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Order;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Orders;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrders extends BaseWidget
{
    protected static ?string $heading = 'Order Terbaru';
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


    protected function getTableQuery(): Builder|Relation|null
    {
        return Orders::query()
            ->latest()
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->label('ID'),
            TextColumn::make('customer.name')->label('Pelanggan')->default('-'),
            TextColumn::make('gross')->label('Total')->money('IDR', true),
            TextColumn::make('payment_status')
                ->label('Status')
                ->badge()
                ->colors([
                    'success' => 'paid',
                    'warning' => 'pending',
                    'info'    => 'unpaid',
                    'danger'  => 'expired',
                ]),
            TextColumn::make('created_at')
                ->label('Tanggal')
                ->dateTime('d M Y H:i'),
        ];
    }
}
