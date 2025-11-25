<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Transaction;
use App\Models\Transactions;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Exports\TransactionExporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use Filament\Tables\Actions\ExportBulkAction;

class TransactionResource extends Resource
{
    protected static ?string $model = Transactions::class;
    protected static ?string $navigationGroup = 'Manjeman Orderan';
    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    public static function getPluralLabel(): string
    {
        return 'Transaksi';
    }
    public static function getLabel(): string
    {
        return 'Transaksi';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
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
                TextColumn::make('order.order_code')
                    ->label('KODE PEMESANAN')
                    ->searchable(),
                TextColumn::make('payment_type')
                    ->label('METODE'),
                TextColumn::make('transaction_status')
                    ->label('STATUS')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'PAID'      => 'success',
                        'PENDING'   => 'warning',
                        'UNPAID'    => 'info',
                        'EXPIRED'    => 'danger',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'PAID' => 'Dibayar',
                        'UNPAID' => 'Belum bayar',
                        'PENDING' => 'Menunggu',
                        'EXPIRED' => 'Kadarluasa',
                        default => 'Gagal',
                    })
                    ->alignCenter(),
                TextColumn::make('gross_amount')
                    ->label('TOTAL')
                    ->formatStateUsing(fn($state) => 'Rp' . number_format($state, 0, ',', '.'))
                    ->summarize(Sum::make()->label('Total Semua Pesanan')),
                TextColumn::make('transaction_time')
                    ->label('BAYAR')
                    ->badge()
                    ->formatStateUsing(
                        fn($state) =>
                        $state
                            ? Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y H:i') . ' WIB'
                            : '-'
                    )
                    ->sortable(),
                TextColumn::make('expiry_time')
                    ->label('BATAS')
                    ->badge()
                    ->formatStateUsing(
                        fn($state) =>
                        $state
                            ? Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y H:i') . ' WIB'
                            : '-'
                    )
                    ->sortable(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(TransactionExporter::class)
            ])
            ->filters([
                SelectFilter::make('transaction_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Menunggu',
                        'paid' => 'Dibayar',
                        'expired' => 'Kadarluasa',
                        'failed' => 'Gagal',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(TransactionExporter::class)
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
