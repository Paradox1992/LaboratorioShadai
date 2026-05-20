<?php

namespace App\Filament\Resources\TipoMuestras\Pages;

use App\Filament\Resources\TipoMuestras\TipoMuestraResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTipoMuestra extends CreateRecord
{
    protected static string $resource = TipoMuestraResource::class;

        protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
