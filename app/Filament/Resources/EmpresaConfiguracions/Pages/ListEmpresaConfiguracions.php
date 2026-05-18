<?php

namespace App\Filament\Resources\EmpresaConfiguracions\Pages;

use App\Filament\Resources\EmpresaConfiguracions\EmpresaConfiguracionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmpresaConfiguracions extends ListRecords
{
    protected static string $resource = EmpresaConfiguracionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
