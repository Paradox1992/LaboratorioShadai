<?php

namespace App\Filament\Resources\ExamenGrupos\Pages;

use App\Filament\Resources\ExamenGrupos\ExamenGrupoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExamenGrupo extends CreateRecord
{
    protected static string $resource = ExamenGrupoResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
