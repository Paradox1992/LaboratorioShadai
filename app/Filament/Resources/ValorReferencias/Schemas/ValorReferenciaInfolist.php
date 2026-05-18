<?php

namespace App\Filament\Resources\ValorReferencias\Schemas;

use App\Models\ValorReferencia;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ValorReferenciaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('variante.id')
                    ->label('Variante'),
                TextEntry::make('nivel.id')
                    ->label('Nivel')
                    ->placeholder('-'),
                TextEntry::make('sexo'),
                TextEntry::make('operador'),
                TextEntry::make('valor_min')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('valor_max')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('valor_texto')
                    ->placeholder('-'),
                TextEntry::make('unidad')
                    ->placeholder('-'),
                TextEntry::make('interpretacion_normal')
                    ->placeholder('-'),
                TextEntry::make('observacion')
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
                    ->visible(fn (ValorReferencia $record): bool => $record->trashed()),
            ]);
    }
}
