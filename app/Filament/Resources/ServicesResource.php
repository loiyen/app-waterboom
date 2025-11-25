<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Services;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ServicesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ServicesResource\RelationManagers;

class ServicesResource extends Resource
{
    protected static ?string $model = Services::class;
    protected static ?string $navigationGroup = 'Manjeman Layanan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    public static function getPluralLabel(): string
    {
        return 'Layanan'; // Teks yang muncul di sidebar
    }
    public static function getLabel(): string
    {
        return 'Layanan'; // Nama tunggal, muncul di form atau detail
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description'),
                TextInput::make('price')
                    ->label('Harga')
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
                FileUpload::make('image')
                    ->label('Upload Foto')
                    ->image()
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
                TextColumn::make('name')
                    ->label('NAMA'),
                TextColumn::make('description')
                    ->label('DESKRIPSI'),
                TextColumn::make('price')
                    ->label('HARGA')
                    ->money('IDR', locale: 'id'),
                TextColumn::make('is_active')
                    ->label('STATUS')
                    ->formatStateUsing(fn($state) => $state ? 'Aktif' : 'Tidak Aktif')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'danger'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateServices::route('/create'),
            'edit' => Pages\EditServices::route('/{record}/edit'),
        ];
    }
}
