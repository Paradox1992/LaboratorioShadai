<?php

namespace App\Filament\Resources\TipoMuestras\Pages;

use App\Filament\Resources\TipoMuestras\TipoMuestraResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTipoMuestra extends EditRecord
{
    protected static string $resource = TipoMuestraResource::class;

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
