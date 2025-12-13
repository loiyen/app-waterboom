<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Ticketprices;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TiketPricesResource\Pages;
use App\Filament\Resources\TiketPricesResource\RelationManagers;

class TiketPricesResource extends Resource
{
    protected static ?string $model = Ticketprices::class;
    protected static ?string $navigationGroup = 'Manjeman Tiket';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function getPluralLabel(): string
    {
        return 'Harga Tiket'; // Teks yang muncul di sidebar
    }
    public static function getLabel(): string
    {
        return 'Harga Tiket'; // Nama tunggal, muncul di form atau detail
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('ticket_id')
                    ->label('Jenis Tiket')
                    ->relationship('ticket', 'ticket_name')
                    ->required(),
                Select::make('ticket_category_id')
                    ->label('Kategori Tiket')
                    ->relationship('ticket_category', 'name')
                    ->required(),
                TextInput::make('price')
                    ->label('Harga Tiket')
                    ->required()
                    ->prefix('Rp')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $numeric = preg_replace('/[^0-9]/', '', $state);
                        if ($numeric === '') {
                            $set('price', '');
                            return;
                        }
                        $set('price', number_format((int) $numeric, 0, ',', '.'));
                    })
                    ->dehydrateStateUsing(function ($state) {
                        return preg_replace('/[^0-9]/', '', $state);
                    })
                    ->formatStateUsing(function ($state) {
                        if ($state === null || $state === '') {
                            return '';
                        }
                        return number_format((int) $state, 0, ',', '.');
                    })
                    ->extraInputAttributes(['inputmode' => 'numeric']),
                DatePicker::make('star_date')
                    ->label('Dari')
                    ->format('Y-m-d')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Sampai')
                    ->format('Y-m-d')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('TANGGAL')
                    ->formatStateUsing(
                        fn($state) =>
                        Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y H:i')
                    )
                    ->sortable()
                    ->wrap(),
                TextColumn::make('ticket.ticket_name')
                    ->label('JENIS TIKET')
                    ->searchable(),
                TextColumn::make('ticket_category.name')
                    ->label('KATEGORI')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-squares-plus' : 'heroicon-o-squares-plus')
                    ->badge(),
                TextColumn::make('price')
                    ->label('HARGA')
                    ->money('IDR', locale: 'id'),
                TextColumn::make('star_date')
                    ->label('DARI'),
                TextColumn::make('end_date')
                    ->label('SAMPAI'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTiketPrices::route('/'),
            'create' => Pages\CreateTiketPrices::route('/create'),
            'edit' => Pages\EditTiketPrices::route('/{record}/edit'),
        ];
    }
}
