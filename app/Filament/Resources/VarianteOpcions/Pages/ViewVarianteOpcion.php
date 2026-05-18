<?php

namespace App\Filament\Resources\VarianteOpcions\Pages;

use App\Filament\Resources\VarianteOpcions\VarianteOpcionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVarianteOpcion extends ViewRecord
{
    protected static string $resource = VarianteOpcionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
