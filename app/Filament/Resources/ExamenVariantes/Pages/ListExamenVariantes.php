<?php

namespace App\Filament\Resources\ExamenVariantes\Pages;

use App\Filament\Resources\ExamenVariantes\ExamenVarianteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExamenVariantes extends ListRecords
{
    protected static string $resource = ExamenVarianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
