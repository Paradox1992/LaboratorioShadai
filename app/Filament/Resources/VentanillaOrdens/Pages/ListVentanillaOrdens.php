<?php

namespace App\Filament\Resources\VentanillaOrdens\Pages;

use App\Filament\Resources\VentanillaOrdens\Support\VentanillaOrdenCreator;
use App\Filament\Resources\VentanillaOrdens\VentanillaOrdenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Schema;

class ListVentanillaOrdens extends ListRecords
{
    protected static string $resource = VentanillaOrdenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Crear')
                ->modalHeading('Nueva orden POS')
                ->modalSubmitActionLabel('Guardar')
                ->modalWidth('7xl')
                ->createAnother(false)
                ->schema(fn (Schema $schema): Schema => VentanillaOrdenResource::form($schema->columns(1)))
                ->using(app(VentanillaOrdenCreator::class)->create(...)),
        ];
    }
}
