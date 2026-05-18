<?php

namespace App\Filament\Resources\RegisteredDevices\Pages;

use App\Filament\Resources\RegisteredDevices\RegisteredDeviceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRegisteredDevices extends ListRecords
{
    protected static string $resource = RegisteredDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
