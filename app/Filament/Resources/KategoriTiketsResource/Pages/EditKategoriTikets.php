<?php

namespace App\Filament\Resources\KategoriTiketsResource\Pages;

use App\Filament\Resources\KategoriTiketsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriTikets extends EditRecord
{
    protected static string $resource = KategoriTiketsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

            Actions\Action::make('tambahBaru')
                ->label('New Kategori Tiket')
                ->color('warning')
                ->url(fn() => static::getResource()::getUrl('create')),
        ];
    }
}
