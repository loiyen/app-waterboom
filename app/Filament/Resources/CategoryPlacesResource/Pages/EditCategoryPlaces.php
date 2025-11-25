<?php

namespace App\Filament\Resources\CategoryPlacesResource\Pages;

use App\Filament\Resources\CategoryPlacesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryPlaces extends EditRecord
{
    protected static string $resource = CategoryPlacesResource::class;

    protected function getHeaderActions(): array
    {
        
        return [
            Actions\DeleteAction::make(),

             Actions\Action::make('tambahBaru')
                ->label('New Kategori Jelajah')
                ->color('warning')
                ->url(fn() => static::getResource()::getUrl('create')),
        ];
    }
}
