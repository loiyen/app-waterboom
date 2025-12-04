<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Abouts;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AboutsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AboutsResource\RelationManagers;

class AboutsResource extends Resource
{
    protected static ?string $model = Abouts::class;
    protected static ?string $navigationGroup = 'Manajemen Navbar';
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    public static function getPluralLabel(): string
    {
        return 'Tentang';
    }
    public static function getLabel(): string
    {
        return 'Tentang';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Judul')
                    ->required(),
                Select::make('sub_content')
                    ->label('Konten')
                    ->options([
                        'waterboom'     => 'Waterboom',
                        'visi'          => 'Visi',
                        'misi'          => 'Misi',
                        'feature'       => 'Feature',
                    ]),
                RichEditor::make('content')
                    ->label('Isi')
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
                    ->required()
                    ->columnSpanFull()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg']),
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
                    ->url(fn($record) => $record->thumbail ? asset('storage/' . $record->image) : null)
                    ->openUrlInNewTab(),
                TextColumn::make('title')
                    ->label('JUDUL'),
                TextColumn::make('content')
                    ->label('DESKRIPSI')
                    ->limit(30)
                    ->tooltip(fn($state) => $state)
                    ->wrap(),
                TextColumn::make('sub_content')
                    ->label('TYPE')
                    ->badge()
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-squares-plus' : 'heroicon-o-squares-plus'),
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
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbouts::route('/create'),
            'edit' => Pages\EditAbouts::route('/{record}/edit'),
        ];
    }
}
