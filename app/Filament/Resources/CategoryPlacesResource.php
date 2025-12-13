<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\Categoryplaces;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryPlacesResource\Pages;
use App\Filament\Resources\CategoryPlacesResource\RelationManagers;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class CategoryPlacesResource extends Resource
{
    protected static ?string $model = Categoryplaces::class;
    protected static ?string $navigationGroup = 'Manajemen Navbar';
    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    public static function getPluralLabel(): string
    {
        return 'Kategori Jelajah';
    }
    public static function getLabel(): string
    {
        return 'Kategori Jelajah';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama'),
                TextColumn::make('slug')
                    ->label('Slug'),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(fn($state) => $state),
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
            'index' => Pages\ListCategoryPlaces::route('/'),
            'create' => Pages\CreateCategoryPlaces::route('/create'),
            'edit' => Pages\EditCategoryPlaces::route('/{record}/edit'),
        ];
    }
}
