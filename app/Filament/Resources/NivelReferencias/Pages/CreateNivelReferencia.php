<?php

namespace App\Filament\Resources\NivelReferencias\Pages;

use App\Filament\Resources\NivelReferencias\NivelReferenciaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNivelReferencia extends CreateRecord
{
    protected static string $resource = NivelReferenciaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
