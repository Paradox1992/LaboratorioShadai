<?php

namespace App\Filament\Resources\AuditoriaEventos\Pages;

use App\Filament\Resources\AuditoriaEventos\AuditoriaEventoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAuditoriaEvento extends ViewRecord
{
    protected static string $resource = AuditoriaEventoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
