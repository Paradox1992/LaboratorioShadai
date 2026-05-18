<?php

namespace App\Filament\Resources\RegisteredDevices\Pages;

use App\Filament\Resources\RegisteredDevices\RegisteredDeviceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRegisteredDevice extends EditRecord
{
    protected static string $resource = RegisteredDeviceResource::class;

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
