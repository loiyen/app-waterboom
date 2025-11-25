<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Tickes;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use function Laravel\Prompts\textarea;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TiketsResource\Pages;

use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TiketsResource\RelationManagers;
use Illuminate\Support\Carbon;

class TiketsResource extends Resource
{
    protected static ?string $model = Tickes::class;
    protected static ?string $navigationGroup = 'Manjeman Tiket';
    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function getPluralLabel(): string
    {
        return 'Tiket'; // Teks yang muncul di sidebar
    }
    public static function getLabel(): string
    {
        return 'Tiket'; // Nama tunggal, muncul di form atau detail
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('ticket_name')
                    ->label('Nama Tiket')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi tiket'),
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
                TextColumn::make('ticket_name')
                    ->label('NAMA TIKET')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('DESKRIPSI'),

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
            'index' => Pages\ListTikets::route('/'),
            'create' => Pages\CreateTikets::route('/create'),
            'edit' => Pages\EditTikets::route('/{record}/edit'),
        ];
    }
}
