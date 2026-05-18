<?php

namespace App\Filament\Resources\NivelReferencias\Pages;

use App\Filament\Resources\NivelReferencias\NivelReferenciaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNivelReferencia extends ViewRecord
{
    protected static string $resource = NivelReferenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
