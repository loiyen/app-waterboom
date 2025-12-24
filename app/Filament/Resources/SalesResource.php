<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sales;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SalesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SalesResource\RelationManagers;

class SalesResource extends Resource
{
    protected static ?string $model = Sales::class;
    protected static ?string $navigationGroup = 'Manjeman Layanan';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getPluralLabel(): string
    {
        return 'Seles'; // Teks yang muncul di sidebar
    }
    public static function getLabel(): string
    {
        return 'Seles'; // Nama tunggal, muncul di form atau detail
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->required(),
                TextInput::make('Nohp')
                    ->label('Nomor Handphone')
                    ->numeric()
                    ->required(),
                FileUpload::make('image')
                    ->label('Upload Foto')
                    ->image()
                    ->required()
                    ->directory('uploads')
                    ->visibility('public')
                    ->maxSize(5048)
                    ->columnSpanFull()
                    ->helperText('Maksimal : 5 MB')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg']),
                Toggle::make('is_active')
                    ->label('Aktifkan postingan?')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark')
                    ->default(true)
                    ->afterStateHydrated(fn(callable $set, $state) => $set('is_active', (bool) $state))
                    ->dehydrateStateUsing(fn($state) => $state ? 1 : 0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image')
                    ->label('FOTO')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Preview' : '-')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-eye' : 'heroicon-o-eye')
                    ->url(fn($record) => $record->image ? asset('storage/' . $record->image) : null)
                    ->openUrlInNewTab(),
                TextColumn::make('name')
                    ->label('NAMA')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('EMAIL')
                    ->searchable(),
                TextColumn::make('Nohp')
                    ->label('NOMOR HP')
                    ->searchable(),
                TextColumn::make('is_active')
                    ->label('STATUS')
                    ->formatStateUsing(fn($state) => $state ? 'Aktif' : 'Tidak Aktif')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'danger'),
            ])
            ->filters([
                
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSales::route('/create'),
            'edit' => Pages\EditSales::route('/{record}/edit'),
        ];
    }
}
