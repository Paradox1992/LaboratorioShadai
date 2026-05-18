<?php

namespace App\Filament\Resources\OrdenExamens\Pages;

use App\Filament\Resources\OrdenExamens\OrdenExamenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrdenExamens extends ListRecords
{
    protected static string $resource = OrdenExamenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
