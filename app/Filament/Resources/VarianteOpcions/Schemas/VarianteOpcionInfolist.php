<?php

namespace App\Filament\Resources\VarianteOpcions\Schemas;

use App\Models\VarianteOpcion;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VarianteOpcionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('variante.id')
                    ->label('Variante'),
                TextEntry::make('valor'),
                TextEntry::make('descripcion')
                    ->placeholder('-'),
                IconEntry::make('es_normal')
                    ->boolean()
                    ->placeholder('-'),
                TextEntry::make('orden')
                    ->numeric(),
                IconEntry::make('estado')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (VarianteOpcion $record): bool => $record->trashed()),
            ]);
    }
}
