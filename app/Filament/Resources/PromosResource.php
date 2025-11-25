<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Promos;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PromosResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PromosResource\RelationManagers;

class PromosResource extends Resource
{
    protected static ?string $model = Promos::class;
    protected static ?string $navigationGroup = 'Manajemen Navbar';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    public static function getPluralLabel(): string
    {
        return 'Promo';
    }
    public static function getLabel(): string
    {
        return 'Promo';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('title')
                    ->label('Judul Promosi')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    })
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(255),
                Select::make('category')
                ->label('Kategori')
                    ->options([
                        'Tiket' => 'Tiket',
                        'Resto' => 'Resto',
                    ]),
                TextInput::make('discount_percent')
                    ->label('Diskon (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%')
                    ->required()
                    ->helperText('Masukkan nilai antara 0 - 100')
                    ->default(0),
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->native(false)
                    ->required()
                    ->displayFormat('d/m/Y')
                    ->format('Y-m-d'),
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->required()
                    ->format('Y-m-d'),
                RichEditor::make('description')
                    ->label('Deskripsi')
                    ->required()
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
                TextColumn::make('title')
                    ->label('JUDUL')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('description')
                    ->label('DESKRIPSI')
                    ->limit(50)
                    ->tooltip(fn($state) => $state)
                    ->wrap(),
                TextColumn::make('start_date')
                    ->label('DARI')
                    ->formatStateUsing(
                        fn($state) =>
                        Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y ')
                    )
                    ->sortable()
                    ->wrap(),
                TextColumn::make('end_date')
                    ->label('SAMPAI')
                    ->formatStateUsing(
                        fn($state) =>
                        Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y ')
                    )
                    ->sortable()
                    ->wrap(),
                TextColumn::make('discount_percent')
                    ->label('DISKON')
                    ->badge()
                    ->color(fn($state) => $state > 50 ? 'success' : 'warning')
                    ->formatStateUsing(fn($state) => $state . '%'),
                TextColumn::make('category')
                    ->label('KATEGORI')
                    ->badge(),
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
            'index' => Pages\ListPromos::route('/'),
            'create' => Pages\CreatePromos::route('/create'),
            'edit' => Pages\EditPromos::route('/{record}/edit'),
        ];
    }
}
