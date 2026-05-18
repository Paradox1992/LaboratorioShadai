<?php

namespace App\Filament\Resources\OrdenLaboratorios\Pages;

use App\Filament\Resources\OrdenLaboratorios\OrdenLaboratorioResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrdenLaboratorios extends ListRecords
{
    protected static string $resource = OrdenLaboratorioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
