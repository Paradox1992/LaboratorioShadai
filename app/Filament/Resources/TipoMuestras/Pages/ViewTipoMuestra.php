<?php

namespace App\Filament\Resources\TipoMuestras\Pages;

use App\Filament\Resources\TipoMuestras\TipoMuestraResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTipoMuestra extends ViewRecord
{
    protected static string $resource = TipoMuestraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
