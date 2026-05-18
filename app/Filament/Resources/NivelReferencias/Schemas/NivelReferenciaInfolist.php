<?php

namespace App\Filament\Resources\NivelReferencias\Schemas;

use App\Models\NivelReferencia;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NivelReferenciaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nombre'),
                TextEntry::make('descripcion')
                    ->placeholder('-'),
                TextEntry::make('edad_min_dias')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('edad_max_dias')
                    ->numeric()
                    ->placeholder('-'),
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
                    ->visible(fn (NivelReferencia $record): bool => $record->trashed()),
            ]);
    }
}
