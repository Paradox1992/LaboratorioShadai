<?php

namespace App\Filament\Resources\Examens\Pages;

use App\Filament\Resources\Examens\ExamenResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExamen extends ViewRecord
{
    protected static string $resource = ExamenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
