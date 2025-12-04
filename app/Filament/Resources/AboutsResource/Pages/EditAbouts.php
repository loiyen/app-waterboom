<?php

namespace App\Filament\Resources\AboutsResource\Pages;

use App\Filament\Resources\AboutsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbouts extends EditRecord
{
    protected static string $resource = AboutsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
