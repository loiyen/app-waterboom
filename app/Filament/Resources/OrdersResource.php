<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Orders;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Exports\OrdersExporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\OrdersResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrdersResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class OrdersResource extends Resource
{
    protected static ?string $model = Orders::class;
    protected static ?string $navigationGroup = 'Manjeman Orderan';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function getPluralLabel(): string
    {
        return 'Checkout';
    }
    public static function getLabel(): string
    {
        return 'Checkout';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->getStateUsing(function ($record, $rowLoop) {
                        return $rowLoop->iteration;
                    })
                    ->alignCenter(),
                TextColumn::make('order_code')
                    ->label('Kode Pemesanan')
                    ->copyable()
                    ->copyMessage('Kode disalin ke clipboard!')
                    ->copyMessageDuration(1500)
                    ->tooltip('Klik untuk menyalin kode pemesanan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('customer.name')
                    ->label('Nama Customer')
                    ->searchable(),
                TextColumn::make('order_date')
                    ->label('Tanggal Pemesanan')
                    ->formatStateUsing(
                        fn($state) =>
                        Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y')
                    )
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'paid'      => 'success',   // hijau
                        'pending'   => 'warning', // kuning
                        'unpaid'    => 'info', // kuning
                        'failed'    => 'danger',  // merah
                        default     => 'gray',     // abu-abu untuk lainnya
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'paid' => 'Dibayar',
                        'unpaid' => 'Menunggu',
                        'expired' => 'Gagal',
                        default => 'Kadarluasa',
                    })
                    ->alignCenter(),
                TextColumn::make('gross')
                    ->label('Total Pembayaran')
                    ->money('IDR', true)
                    ->formatStateUsing(fn($state) => 'Rp' . number_format($state, 0, ',', '.'))
                     ->summarize(Sum::make()->label('Total Semua Pesanan'))
                    ->sortable(),
                // TextColumn::make('gross')
                //     ->label('Total')
                //     ->money('IDR', true)   
            ])
            ->headerActions([
                ExportAction::make()->exporter(OrdersExporter::class)
            ])->filters([
                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Menunggu',
                        'paid' => 'Dibayar',
                        'expired' => 'Kadarluasa',
                        'failed' => 'Gagal',
                    ]),
                Tables\Filters\Filter::make('hari_ini')
                    ->label('Hari Ini')
                    ->query(
                        fn($query) =>
                        $query->whereDate('created_at', Carbon::today())
                    ),

                Tables\Filters\Filter::make('kemarin')
                    ->label('Kemarin')
                    ->query(
                        fn($query) =>
                        $query->whereDate('created_at', Carbon::yesterday())
                    ),

                Tables\Filters\Filter::make('7_hari_terakhir')
                    ->label('7 Hari Terakhir')
                    ->query(
                        fn($query) =>
                        $query->whereBetween('created_at', [
                            Carbon::now()->subDays(7),
                            Carbon::now(),
                        ])
                    ),
                Tables\Filters\Filter::make('bulan_ini')
                    ->label('Bulan Ini')
                    ->query(
                        fn($query) =>
                        $query->whereMonth('created_at', Carbon::now()->month)
                    ),
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('dari')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['dari'],
                                fn($q) => $q->whereDate('created_at', '>=', $data['dari'])
                            )
                            ->when(
                                $data['sampai'],
                                fn($q) => $q->whereDate('created_at', '<=', $data['sampai'])
                            );
                    })
                    ->label('Rentang Tanggal'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                 ExportBulkAction::make()->exporter(OrdersExporter::class),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrders::route('/create'),
            'edit' => Pages\EditOrders::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
