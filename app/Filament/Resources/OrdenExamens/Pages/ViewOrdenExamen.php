<?php

namespace App\Filament\Resources\OrdenExamens\Pages;

use App\Filament\Resources\OrdenExamens\OrdenExamenResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrdenExamen extends ViewRecord
{
    protected static string $resource = OrdenExamenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
