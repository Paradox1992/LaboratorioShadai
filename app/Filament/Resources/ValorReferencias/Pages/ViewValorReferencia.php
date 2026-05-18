<?php

namespace App\Filament\Resources\ValorReferencias\Pages;

use App\Filament\Resources\ValorReferencias\ValorReferenciaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewValorReferencia extends ViewRecord
{
    protected static string $resource = ValorReferenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
