<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Galleries;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use function Laravel\Prompts\select;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GaleriResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GaleriResource\RelationManagers;

class GaleriResource extends Resource
{
    protected static ?string $model = Galleries::class;

    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function getPluralLabel(): string
    {
        return 'Galeri'; 
    }
    public static function getLabel(): string
    {
        return 'Galeri'; 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category')
                    ->label('Kategori')
                    ->preload()
                    ->native()
                    ->placeholder('Pilih Kategori')
                    ->options([
                        'tiket'         => 'Tiket',
                        'slider'        => 'Slider',
                        'penghargaan dan prestasi' => 'Penghargaan dan prestasi',
                        'partner'       => 'Partner',
                        'checkout'      => 'checkout',
                    ]),
                TextInput::make('title')
                    ->label('Judul'),
                FileUpload::make('image')
                    ->label('Upload Foto')
                    ->image()
                    ->directory('uploads')
                    ->visibility('public')
                    ->enableDownload()
                    ->enableOpen()
                    ->maxSize(5048)
                    ->helperText('Maksimal : 5 MB')
                    ->columnSpanFull()
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
                TextColumn::make('image')
                    ->label('FOTO')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Preview' : '-')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-eye' : 'heroicon-o-eye')
                    ->url(fn($record) => $record->image ? asset('storage/' . $record->image) : null)
                    ->openUrlInNewTab(),
                TextColumn::make('category')
                    ->label('KATEGORI')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-squares-plus' : 'heroicon-o-squares-plus')
                    ->badge(),
                TextColumn::make('title')
                    ->label('NAMA')
                    ->searchable(),

                TextColumn::make('is_active')
                    ->label('STATUS')
                    ->badge()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Aktif' : 'Nonaktif')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
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
            'index' => Pages\ListGaleris::route('/'),
            'create' => Pages\CreateGaleri::route('/create'),
            'edit' => Pages\EditGaleri::route('/{record}/edit'),
        ];
    }
}
