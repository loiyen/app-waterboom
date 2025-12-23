<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use App\Models\User;

class UserActivity extends TableWidget
{
    protected static ?string $heading = 'Aktivitas User';
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->orderByDesc('last_login_at')->limit(8))
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('User')->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('last_login_at')
                    ->label('Last Login')
                    ->formatStateUsing(
                        fn($state) =>
                        $state
                            ? \Carbon\Carbon::parse($state)->diffForHumans()
                            : 'Never'
                    ),
                Tables\Columns\TextColumn::make('roles.name')->label('Role')->badge(),
            ]);
    }
}
