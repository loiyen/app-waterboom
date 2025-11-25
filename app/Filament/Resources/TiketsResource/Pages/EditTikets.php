<?php

namespace App\Filament\Resources\TiketsResource\Pages;

use App\Filament\Resources\TiketsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTikets extends EditRecord
{
    protected static string $resource = TiketsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

            Actions\Action::make('tambahBaru')
                ->label('New Tiket')
                ->color('warning')
                ->url(fn() => static::getResource()::getUrl('create')),
        ];
    }
}
