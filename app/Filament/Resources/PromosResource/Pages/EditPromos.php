<?php

namespace App\Filament\Resources\PromosResource\Pages;

use App\Filament\Resources\PromosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPromos extends EditRecord
{
    protected static string $resource = PromosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
            Actions\DeleteAction::make(),

            Actions\Action::make('tambahBaru')
                ->label('New Promo')
                ->color('warning')
                ->url(fn() => static::getResource()::getUrl('create')),
        ];
    }
}
