<?php

namespace App\Filament\Resources\Examens\Pages;

use App\Filament\Resources\Examens\ExamenResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExamen extends CreateRecord
{
    protected static string $resource = ExamenResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
