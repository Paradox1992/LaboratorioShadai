<?php

namespace App\Filament\Resources\VarianteOpcions\Pages;

use App\Filament\Resources\VarianteOpcions\VarianteOpcionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVarianteOpcions extends ListRecords
{
    protected static string $resource = VarianteOpcionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
