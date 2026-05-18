<?php

namespace App\Filament\Resources\ResultadoExamens\Pages;

use App\Filament\Resources\ResultadoExamens\ResultadoExamenResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewResultadoExamen extends ViewRecord
{
    protected static string $resource = ResultadoExamenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
