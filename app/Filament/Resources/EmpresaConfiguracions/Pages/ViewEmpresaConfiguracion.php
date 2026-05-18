<?php

namespace App\Filament\Resources\EmpresaConfiguracions\Pages;

use App\Filament\Resources\EmpresaConfiguracions\EmpresaConfiguracionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEmpresaConfiguracion extends ViewRecord
{
    protected static string $resource = EmpresaConfiguracionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
