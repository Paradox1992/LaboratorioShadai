<?php

namespace App\Filament\Resources\TipoMuestras\Pages;

use App\Filament\Resources\TipoMuestras\TipoMuestraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTipoMuestras extends ListRecords
{
    protected static string $resource = TipoMuestraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
