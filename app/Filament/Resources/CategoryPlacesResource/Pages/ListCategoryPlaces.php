<?php

namespace App\Filament\Resources\CategoryPlacesResource\Pages;

use App\Filament\Resources\CategoryPlacesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryPlaces extends ListRecords
{
    protected static string $resource = CategoryPlacesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
