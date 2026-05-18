<?php

namespace App\Filament\Resources\UnidadMedidas\Pages;

use App\Filament\Resources\UnidadMedidas\UnidadMedidaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUnidadMedida extends ViewRecord
{
    protected static string $resource = UnidadMedidaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
