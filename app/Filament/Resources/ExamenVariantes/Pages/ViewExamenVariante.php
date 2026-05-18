<?php

namespace App\Filament\Resources\ExamenVariantes\Pages;

use App\Filament\Resources\ExamenVariantes\ExamenVarianteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExamenVariante extends ViewRecord
{
    protected static string $resource = ExamenVarianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
