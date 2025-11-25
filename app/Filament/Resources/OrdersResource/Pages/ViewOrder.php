<?php

namespace App\Filament\Resources\OrdersResource\Pages;

use App\Filament\Resources\OrdersResource;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrdersResource::class;

     protected static string $view = 'backend.filament.order-resource.pages.view_DetailOrder';
}
