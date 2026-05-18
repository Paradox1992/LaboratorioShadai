<?php

namespace App\Filament\Resources\VentanillaOrdens\Pages;

use App\Filament\Resources\VentanillaOrdens\VentanillaOrdenResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVentanillaOrden extends ViewRecord
{
    protected static string $resource = VentanillaOrdenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
