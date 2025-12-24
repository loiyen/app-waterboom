<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\UsersResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UsersResource\RelationManagers;

class UsersResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Manjeman User';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getPluralLabel(): string
    {
        return 'User';
    }
    public static function getLabel(): string
    {
        return 'User';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->required(),
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->required()
                    ->helperText('Pilih roles sesuai hak akses'),
                DateTimePicker::make('email_verified_at')
                    ->label('Email Verified At')
                    ->nullable()
                    ->required()
                    ->helperText('Kosongkan jika belum diverifikasi.'),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => !empty($state) ? bcrypt($state) : null)
                    ->dehydrated(fn($state) => filled($state))
                    ->maxLength(255)
                    ->required()
                    ->helperText('Gunakan kata sandi yang kuat min.8 karakter.'),
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
                TextColumn::make('name')
                    ->label('NAMA')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('EMAIL'),
                TextColumn::make('email_verified_at')
                    ->label('EMAIL VERIFIKASI'),
                TextColumn::make('roles.name')
                    ->label('HAK AKSES')
                    ->badge(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'edit' => Pages\EditUsers::route('/{record}/edit'),
        ];
    }
}
