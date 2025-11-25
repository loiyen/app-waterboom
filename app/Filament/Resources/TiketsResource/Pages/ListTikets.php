<?php

namespace App\Filament\Resources\TiketsResource\Pages;

use App\Filament\Resources\TiketsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTikets extends ListRecords
{
    protected static string $resource = TiketsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
