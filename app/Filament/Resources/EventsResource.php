<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Events;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\EventsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventsResource\RelationManagers;

class EventsResource extends Resource
{
    protected static ?string $model = Events::class;
    protected static ?string $navigationGroup = 'Manajemen Navbar';
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function getPluralLabel(): string
    {
        return 'Event & Acara';
    }
    public static function getLabel(): string
    {
        return 'Event & Acara';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Judul')
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
                    ])->columnSpanFull()
                    ->required(),
                RichEditor::make('ketentuan')
                    ->label('Ketentuan')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'subscript',
                        'superscript',
                        'heading',
                        'alignLeft',
                        'alignCenter',
                        'alignRight',
                        'alignJustify',
                        'orderedList',
                        'bulletList',
                        'blockquote',
                        'codeBlock',
                        'horizontalRule',
                        'link',
                        'clearFormatting',
                        'undo',
                        'redo',
                    ])
                    ->columnSpanFull()
                    ->required(),
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->format('Y-m-d'),
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->format('Y-m-d'),
                FileUpload::make('thumbail')
                    ->label('Upload Foto')
                    ->image()
                    ->directory('uploads')
                    ->visibility('public')
                    ->maxSize(5048)
                    ->required()
                    ->columnSpanFull()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg']),
                TextInput::make('location')
                    ->label('Lokasi')
                    ->maxLength(255),
                TextInput::make('link')
                    ->label('Link informasi')
                    ->maxLength(255),
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
                TextColumn::make('thumbail')
                    ->label('FOTO')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Preview' : '-')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-eye' : 'heroicon-o-eye')
                    ->url(fn($record) => $record->thumbail ? asset('storage/' . $record->thumbail) : null)
                    ->openUrlInNewTab(),
                TextColumn::make('title')
                    ->label('JUDUL')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('DESKRIPSI')
                    ->limit(30)
                    ->tooltip(fn($state) => $state)
                    ->wrap(),
                TextColumn::make('start_date')
                    ->label('MULAI')
                    ->formatStateUsing(
                        fn($state) =>
                        Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y')
                    )
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('SELESAI')
                    ->formatStateUsing(
                        fn($state) =>
                        Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y')
                    )
                    ->sortable(),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvents::route('/create'),
            'edit' => Pages\EditEvents::route('/{record}/edit'),
        ];
    }
}
