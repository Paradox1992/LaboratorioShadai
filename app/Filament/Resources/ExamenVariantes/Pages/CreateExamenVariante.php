<?php

namespace App\Filament\Resources\ExamenVariantes\Pages;

use App\Filament\Resources\ExamenVariantes\ExamenVarianteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExamenVariante extends CreateRecord
{
    protected static string $resource = ExamenVarianteResource::class;

        protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
