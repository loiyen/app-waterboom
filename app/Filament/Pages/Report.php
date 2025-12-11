<?php

namespace App\Filament\Pages;

use Filament\Tables;
use App\Models\Orders;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Tables\Actions\Action;
use App\Filament\Exports\OrdersExporter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;


class Report extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;


    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Laporan Order';
    protected static ?string $navigationGroup = 'Manajemen Laporan';
    protected static string $view = 'filament.pages.report';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function shouldRegisterNavigationGroup(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }


    public function getTableQuery(): Builder
    {
        return Orders::query()->latest();
    }

    public function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('date_range')
                ->form([
                    DatePicker::make('from')
                        ->label('Dari'),
                    DatePicker::make('until')
                        ->label('Sampai'),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query
                        ->when(
                            $data['from'] ?? null,
                            fn($q) =>
                            $q->whereDate('order_date', '>=', $data['from'])
                        )
                        ->when(
                            $data['until'] ?? null,
                            fn($q) =>
                            $q->whereDate('order_date', '<=', $data['until'])
                        );
                }),

            Tables\Filters\SelectFilter::make('payment_status')
                ->label('Status Pembayaran')
                ->options([
                    'paid'          => 'Lunas',
                    'pending'       => 'Menunggu',
                    'unpaid'        => 'Belum bayar',
                    'expiried'      => 'Kadarluasa',
                ]),
        ];
    }

    public function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('no')
                ->label('No')
                ->getStateUsing(function ($record, $rowLoop, $livewire) {
                    $page = $livewire->getPage();          // halaman saat ini
                    $perPage = $livewire->getTableRecordsPerPage(); // jumlah data per halaman

                    return ($page - 1) * $perPage + $rowLoop->iteration;
                })
                ->alignCenter(),

            Tables\Columns\TextColumn::make('order_date')
                ->label('TANGGAL PEMESANAN')
                ->formatStateUsing(
                    fn($state) =>
                    $state
                        ? Carbon::parse($state)->locale('id')->translatedFormat('d F Y')
                        : null
                )
                ->sortable(),

            Tables\Columns\TextColumn::make('order_code')
                ->label('KODE PEMESANAN'),

            Tables\Columns\BadgeColumn::make('payment_status')
                ->label('STATUS PEMESANAN'),

            Tables\Columns\TextColumn::make('customer.name')
                ->searchable()
                ->label('CUSTOMER'),

            Tables\Columns\TextColumn::make('gross')
                ->label('TOTAL')
                ->money('IDR'),

            Tables\Columns\TextColumn::make('created_at')
                ->label('DIBUAT')
                ->dateTime(),


        ];
    }
    public function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('print')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->url(fn($record) => route('print.orderbyid', $record->id))
                ->openUrlInNewTab(),
        ];
    }

    public function getTableHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->url(fn() => $this->makePrintUrl())
                ->openUrlInNewTab(),
            ExportAction::make()->exporter(OrdersExporter::class),
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),

        ];
    }

    private function makePrintUrl(): string
    {
        // Ambil filter yang sudah diterapkan user
        $filters = $this->getTableFiltersForm()->getState();

        return url('/print/orders?' . http_build_query($filters));
    }
}
