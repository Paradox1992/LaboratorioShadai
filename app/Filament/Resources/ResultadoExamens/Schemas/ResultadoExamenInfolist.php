<?php

namespace App\Filament\Resources\ResultadoExamens\Schemas;

use App\Models\ResultadoExamen;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ResultadoExamenInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ordenExamen.id')
                    ->label('Orden examen'),
                TextEntry::make('variante.id')
                    ->label('Variante'),
                TextEntry::make('valorReferencia.id')
                    ->label('Valor referencia')
                    ->placeholder('-'),
                TextEntry::make('resultado_numero')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('resultado_texto')
                    ->placeholder('-'),
                TextEntry::make('unidad')
                    ->placeholder('-'),
                TextEntry::make('variante_nombre_snapshot')
                    ->placeholder('-'),
                TextEntry::make('ref_nivel_nombre')
                    ->placeholder('-'),
                TextEntry::make('ref_sexo')
                    ->placeholder('-'),
                TextEntry::make('ref_operador')
                    ->placeholder('-'),
                TextEntry::make('ref_valor_min')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('ref_valor_max')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('ref_valor_texto')
                    ->placeholder('-'),
                TextEntry::make('ref_unidad')
                    ->placeholder('-'),
                TextEntry::make('estado_resultado'),
                TextEntry::make('validado_por')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('fecha_validacion')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('observacion')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ResultadoExamen $record): bool => $record->trashed()),
            ]);
    }
}
