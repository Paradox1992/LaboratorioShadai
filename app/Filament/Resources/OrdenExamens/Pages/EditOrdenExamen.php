<?php

namespace App\Filament\Resources\OrdenExamens\Pages;

use App\Filament\Resources\OrdenExamens\OrdenExamenResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOrdenExamen extends EditRecord
{
    protected static string $resource = OrdenExamenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
