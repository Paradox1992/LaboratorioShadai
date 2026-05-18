<?php

namespace App\Filament\Resources\ValorReferencias\Pages;

use App\Filament\Resources\ValorReferencias\ValorReferenciaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListValorReferencias extends ListRecords
{
    protected static string $resource = ValorReferenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
