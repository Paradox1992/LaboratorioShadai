<?php

namespace App\Filament\Resources\NivelReferencias\Pages;

use App\Filament\Resources\NivelReferencias\NivelReferenciaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNivelReferencias extends ListRecords
{
    protected static string $resource = NivelReferenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
