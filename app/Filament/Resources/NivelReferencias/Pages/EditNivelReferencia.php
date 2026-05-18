<?php

namespace App\Filament\Resources\NivelReferencias\Pages;

use App\Filament\Resources\NivelReferencias\NivelReferenciaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditNivelReferencia extends EditRecord
{
    protected static string $resource = NivelReferenciaResource::class;

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
