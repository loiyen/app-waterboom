<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Places;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use function Laravel\Prompts\textarea;

use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PlacesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use App\Filament\Resources\PlacesResource\RelationManagers;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PlacesResource extends Resource
{
    protected static ?string $model = Places::class;
    protected static ?string $navigationGroup = 'Manajemen Wahana';
    protected static ?string $navigationIcon = 'heroicon-o-globe-europe-africa';

    public static function getPluralLabel(): string
    {
        return 'Jelajah';
    }
    public static function getLabel(): string
    {
        return 'Jelajah';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('category_place_id')
                            ->label('Pilih Kategori')
                            ->relationship('categoryplace', 'name')
                            ->required(),

                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->disabled()
                            ->dehydrated()
                            ->maxLength(255),
                    ]),
                RichEditor::make('description')
                    ->label('Deskripsi')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'orderedList',
                        'bulletList',
                        'blockquote',
                        'codeBlock',
                        'undo',
                        'redo',
                    ])
                    ->columnSpanFull()
                    ->required(),
                SpatieMediaLibraryFileUpload::make('images')
                    ->label('Gambar Tempat')
                    ->collection('places-images')
                    ->multiple()
                    ->required()
                    ->image()
                    ->rules(['image', 'max:5048'])
                    ->columnSpanFull()
                    ->preserveFilenames(),
                Grid::make(2)
                    ->schema([
                        TimePicker::make('open')
                            ->label('Jam Buka')
                            ->seconds(false)
                            ->required(),
                        TimePicker::make('close')
                            ->label('Jam Tutup')
                            ->seconds(false)
                            ->required(),
                    ]),
                Toggle::make('is_active')
                    ->label('Aktifkan postingan?')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark')
                    ->default(true)
                    ->afterStateHydrated(fn(callable $set, $state) => $set('is_active', (bool) $state))
                    ->dehydrateStateUsing(fn($state) => $state ? 1 : 0)

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
                TextColumn::make('categoryplace.name')
                    ->label('KATEGORI')
                    ->badge()
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-squares-plus' : 'heroicon-o-squares-plus'),
                SpatieMediaLibraryImageColumn::make('images')
                    ->label('FOTO')
                    ->collection('places-images')
                    ->square(),
                TextColumn::make('name')
                    ->label('NAMA')
                    ->searchable(),
                // TextColumn::make('description')
                //     ->label('DESKRIPSI')
                //     ->limit(30)
                //     ->tooltip(fn($state) => $state)
                //     ->wrap(),
                TextColumn::make('open')
                    ->label('BUKA'),
                TextColumn::make('close')
                    ->label('TUTUP'),
                TextColumn::make('is_active')
                    ->label('STATUS')
                    ->badge()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Aktif' : 'Nonaktif')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPlaces::route('/'),
            'create' => Pages\CreatePlaces::route('/create'),
            'edit' => Pages\EditPlaces::route('/{record}/edit'),
        ];
    }
}
