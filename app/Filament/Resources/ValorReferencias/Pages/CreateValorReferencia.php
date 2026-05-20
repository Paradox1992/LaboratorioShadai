<?php

namespace App\Filament\Resources\ValorReferencias\Pages;

use App\Filament\Resources\ValorReferencias\ValorReferenciaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateValorReferencia extends CreateRecord
{
    protected static string $resource = ValorReferenciaResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
