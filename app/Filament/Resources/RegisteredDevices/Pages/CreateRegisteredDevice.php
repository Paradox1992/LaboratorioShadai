<?php

namespace App\Filament\Resources\RegisteredDevices\Pages;

use App\Filament\Resources\RegisteredDevices\RegisteredDeviceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRegisteredDevice extends CreateRecord
{
    protected static string $resource = RegisteredDeviceResource::class;
}
