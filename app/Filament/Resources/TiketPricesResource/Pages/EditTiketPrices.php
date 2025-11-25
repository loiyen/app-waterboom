<?php

namespace App\Filament\Resources\TiketPricesResource\Pages;

use App\Filament\Resources\TiketPricesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTiketPrices extends EditRecord
{
    protected static string $resource = TiketPricesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

            Actions\Action::make('tambahBaru')
                ->label('New Harga Tiket')
                ->color('warning')
                ->url(fn() => static::getResource()::getUrl('create')),
        ];
    }
}
