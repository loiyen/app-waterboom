<?php

namespace App\Filament\Resources\TiketPricesResource\Pages;

use App\Filament\Resources\TiketPricesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTiketPrices extends ListRecords
{
    protected static string $resource = TiketPricesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
