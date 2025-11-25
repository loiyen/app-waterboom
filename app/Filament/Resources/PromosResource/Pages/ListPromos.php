<?php

namespace App\Filament\Resources\PromosResource\Pages;

use App\Filament\Resources\PromosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPromos extends ListRecords
{
    protected static string $resource = PromosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
