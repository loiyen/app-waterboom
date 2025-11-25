<?php

namespace App\Filament\Resources\KategoriTiketsResource\Pages;

use App\Filament\Resources\KategoriTiketsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriTikets extends ListRecords
{
    protected static string $resource = KategoriTiketsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
