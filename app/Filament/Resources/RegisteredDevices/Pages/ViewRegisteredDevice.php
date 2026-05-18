<?php

namespace App\Filament\Resources\RegisteredDevices\Pages;

use App\Filament\Resources\RegisteredDevices\RegisteredDeviceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRegisteredDevice extends ViewRecord
{
    protected static string $resource = RegisteredDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
