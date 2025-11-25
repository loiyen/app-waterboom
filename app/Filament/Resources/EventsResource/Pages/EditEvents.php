<?php

namespace App\Filament\Resources\EventsResource\Pages;

use App\Filament\Resources\EventsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvents extends EditRecord
{
    protected static string $resource = EventsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

            Actions\Action::make('tambahBaru')
                ->label('New Event & Acara')
                ->color('warning')
                ->url(fn() => static::getResource()::getUrl('create')),
        ];
    }
}
