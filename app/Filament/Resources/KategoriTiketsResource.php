<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use App\Models\Ticketcategories;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KategoriTiketsResource\Pages;
use App\Filament\Resources\KategoriTiketsResource\RelationManagers;

class KategoriTiketsResource extends Resource
{
    protected static ?string $model = Ticketcategories::class;
    protected static ?string $navigationGroup = 'Manjeman Tiket';
    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    public static function getPluralLabel(): string
    {
        return 'Kategori Tiket'; // Teks yang muncul di sidebar
    }
    public static function getLabel(): string
    {
        return 'Kategori Tiket'; // Nama tunggal, muncul di form atau detail
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi Kategori'),
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
                TextColumn::make('name')
                    ->label('NAMA'),
                TextColumn::make('description')
                    ->label('DESKRIPSI'),

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
            'index' => Pages\ListKategoriTikets::route('/'),
            'create' => Pages\CreateKategoriTikets::route('/create'),
            'edit' => Pages\EditKategoriTikets::route('/{record}/edit'),
        ];
    }
}
