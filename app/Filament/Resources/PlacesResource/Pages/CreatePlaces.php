<?php

namespace App\Filament\Resources\PlacesResource\Pages;


use Filament\Actions;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Log;
use App\Filament\Resources\PlacesResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlaces extends CreateRecord
{
    protected static string $resource = PlacesResource::class;

    
}
