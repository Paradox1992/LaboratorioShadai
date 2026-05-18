<?php

namespace App\Filament\Resources\ResultadoExamens\Pages;

use App\Filament\Resources\ResultadoExamens\ResultadoExamenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListResultadoExamens extends ListRecords
{
    protected static string $resource = ResultadoExamenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
