<?php

namespace App\Filament\Resources\AuditoriaEventos\Pages;

use App\Filament\Resources\AuditoriaEventos\AuditoriaEventoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAuditoriaEventos extends ListRecords
{
    protected static string $resource = AuditoriaEventoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
