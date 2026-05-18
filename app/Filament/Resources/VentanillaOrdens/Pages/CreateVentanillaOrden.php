<?php

namespace App\Filament\Resources\VentanillaOrdens\Pages;

use App\Filament\Resources\VentanillaOrdens\Support\VentanillaOrdenCreator;
use App\Filament\Resources\VentanillaOrdens\VentanillaOrdenResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateVentanillaOrden extends CreateRecord
{
    protected static string $resource = VentanillaOrdenResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordCreation(array $data): Model
    {
        return app(VentanillaOrdenCreator::class)->create($data);
    }
}
