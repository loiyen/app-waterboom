<?php

namespace App\Filament\Resources;

use DateTime;
use Filament\Forms;
use App\Models\News;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\NewsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NewsResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;
    protected static ?string $navigationGroup = 'Manajemen Artikel & Berita';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function getPluralLabel(): string
    {
        return 'Berita';
    }
    public static function getLabel(): string
    {
        return 'Berita';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('user_display')
                    ->label('User')
                    ->default(fn() => auth()->user()->name)
                    ->disabled()
                    ->dehydrated(false),
                Hidden::make('user_id')
                    ->default(fn() => auth()->id()),
                Select::make('category_news_id')
                    ->label('Pilih Kategori')
                    ->relationship('category_news', 'name')
                    ->required(),

                Textarea::make('title')
                    ->label('Judul Berita')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),
                Textarea::make('summary')
                    ->label('Ringkasan Berita')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(255),
                RichEditor::make('content')
                    ->label('Isi')
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
                SpatieMediaLibraryFileUpload::make('images')
                    ->label('Gambar Berita')
                    ->collection('news-images')
                    ->multiple()
                    ->image()
                    ->rules(['image', 'max:5048'])
                    ->columnSpanFull()
                    ->preserveFilenames(),
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
                SpatieMediaLibraryImageColumn::make('images')
                    ->label('FOTO')
                    ->collection('news-images')
                    ->square(),
                TextColumn::make('user.name')
                    ->label('NAMA')
                    ->icon('heroicon-m-user')
                    ->badge()
                    ->searchable(),
                TextColumn::make('category_news.name')
                    ->label('KATEGORI')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-squares-plus' : 'heroicon-o-squares-plus')
                    ->badge(),
                TextColumn::make('title')
                    ->label('JUDUL')
                    ->wrap()
                    ->searchable(),
                // TextColumn::make('summary')
                //     ->label('RINGKASAN')
                //     ->limit(50)
                //     ->tooltip(fn($state) => $state)
                //     ->wrap(),
                // TextColumn::make('content')
                //     ->label('ISI')
                //     ->limit(30)
                //     ->tooltip(fn($state) => $state)
                //     ->wrap(),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
