<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Holidays;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HolidaysResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HolidaysResource\RelationManagers;

class HolidaysResource extends Resource
{
    protected static ?string $model = Holidays::class;
    protected static ?string $navigationGroup = 'Manjeman Tiket';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function getPluralLabel(): string
    {
        return 'Liburan'; // Teks yang muncul di sidebar
    }
    public static function getLabel(): string
    {
        return 'Liburan'; // Nama tunggal, muncul di form atau detail
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->format('Y-m-d')
                    ->required(),
                    TextInput::make('name')
                    ->label('Nama')
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
                TextColumn::make('date')
                    ->label('TANGGAL LIBUR')
                    ->formatStateUsing(
                        fn($state) =>
                        Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y ')
                    )
                    ->sortable()
                    ->wrap(),
                TextColumn::make('name')
                    ->label('NAMA')
                    ->searchable(),

            ])
            ->filters([
                //
            ])
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
            'index' => Pages\ListHolidays::route('/'),
            'create' => Pages\CreateHolidays::route('/create'),
            'edit' => Pages\EditHolidays::route('/{record}/edit'),
        ];
    }
}
