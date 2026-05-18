<?php

namespace App\Filament\Resources\ExamenGrupos\Pages;

use App\Filament\Resources\ExamenGrupos\ExamenGrupoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExamenGrupo extends ViewRecord
{
    protected static string $resource = ExamenGrupoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
