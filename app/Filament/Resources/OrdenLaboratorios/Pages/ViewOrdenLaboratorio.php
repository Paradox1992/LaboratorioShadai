<?php

namespace App\Filament\Resources\OrdenLaboratorios\Pages;

use App\Filament\Resources\OrdenLaboratorios\OrdenLaboratorioResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrdenLaboratorio extends ViewRecord
{
    protected static string $resource = OrdenLaboratorioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
