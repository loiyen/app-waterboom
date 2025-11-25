<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Customers;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\CustomersExporter;
use App\Filament\Resources\CustomersResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomersResource\RelationManagers;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;

class CustomersResource extends Resource
{
    protected static ?string $model = Customers::class;
    protected static ?string $navigationGroup = 'Manajemen Pelanggan';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getPluralLabel(): string
    {
        return 'Customer';
    }
    public static function getLabel(): string
    {
        return 'Customer';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('NAMA')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('EMAIL'),
                TextColumn::make('phone')
                    ->label('NO HANDPHONE')
                    ->searchable(),
                TextColumn::make('address')
                    ->label('ALAMAT')
                    ->limit(30)
                    ->tooltip(fn($state) => $state),
            ])
            ->headerActions([
                ExportAction::make()->exporter(CustomersExporter::class),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(CustomersExporter::class),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomers::route('/create'),
            'edit' => Pages\EditCustomers::route('/{record}/edit'),
        ];
    }
}
