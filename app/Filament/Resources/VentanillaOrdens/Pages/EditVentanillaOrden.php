<?php

namespace App\Filament\Resources\VentanillaOrdens\Pages;

use App\Filament\Resources\VentanillaOrdens\VentanillaOrdenResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVentanillaOrden extends EditRecord
{
    protected static string $resource = VentanillaOrdenResource::class;

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
