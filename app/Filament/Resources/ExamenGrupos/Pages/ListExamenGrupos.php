<?php

namespace App\Filament\Resources\ExamenGrupos\Pages;

use App\Filament\Resources\ExamenGrupos\ExamenGrupoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExamenGrupos extends ListRecords
{
    protected static string $resource = ExamenGrupoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
