<?php

namespace App\Filament\Resources\ResultadoExamens\Pages;

use App\Filament\Resources\ResultadoExamens\ResultadoExamenResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditResultadoExamen extends EditRecord
{
    protected static string $resource = ResultadoExamenResource::class;

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
