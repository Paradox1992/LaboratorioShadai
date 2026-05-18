<?php

namespace App\Filament\Resources\VentanillaOrdens\Schemas;

use App\Models\ResultadoExamen;
use App\Models\VentanillaOrden;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VentanillaOrdenInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('paciente.nombre_completo')
                    ->label('Cliente'),
                TextEntry::make('observacion')
                    ->placeholder('-')
                    ->columnSpanFull(),
                RepeatableEntry::make('examenes_variantes')
                    ->label('Examenes y variantes')
                    ->state(self::examenesVariantesState(...))
                    ->table([
                        TableColumn::make('Examen'),
                        TableColumn::make('Variante'),
                        TableColumn::make('Nivel'),
                        TableColumn::make('Referencia'),
                        TableColumn::make('Resultado'),
                    ])
                    ->schema([
                        TextEntry::make('examen')
                            ->placeholder('-'),
                        TextEntry::make('variante')
                            ->placeholder('-'),
                        TextEntry::make('nivel')
                            ->placeholder('-'),
                        TextEntry::make('referencia')
                            ->placeholder('-'),
                        TextEntry::make('resultado')
                            ->placeholder('-'),
                    ])
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Creada')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (VentanillaOrden $record): bool => $record->trashed()),
            ]);
    }

    /**
     * @return array<int, array<string, string|null>>
     */
    private static function examenesVariantesState(VentanillaOrden $record): array
    {
        $orden = $record->ordenLaboratorio()
            ->with('examenesOrdenados.resultados')
            ->first();

        if (! $orden) {
            return [];
        }

        return $orden->examenesOrdenados
            ->flatMap(fn ($ordenExamen) => $ordenExamen->resultados->map(fn (ResultadoExamen $resultado): array => [
                'examen' => $ordenExamen->nombre_examen_snapshot,
                'variante' => $resultado->variante_nombre_snapshot,
                'nivel' => $resultado->ref_nivel_nombre,
                'referencia' => self::referenciaLabel($resultado),
                'resultado' => self::resultadoLabel($resultado),
            ]))
            ->values()
            ->all();
    }

    private static function referenciaLabel(ResultadoExamen $resultado): string
    {
        if (filled($resultado->ref_valor_texto)) {
            return $resultado->ref_valor_texto;
        }

        $min = $resultado->ref_valor_min;
        $max = $resultado->ref_valor_max;
        $unidad = $resultado->ref_unidad ? " {$resultado->ref_unidad}" : '';

        if (filled($min) && filled($max)) {
            return "{$min} - {$max}{$unidad}";
        }

        if (filled($min)) {
            return "Desde {$min}{$unidad}";
        }

        if (filled($max)) {
            return "Hasta {$max}{$unidad}";
        }

        return '-';
    }

    private static function resultadoLabel(ResultadoExamen $resultado): string
    {
        if (filled($resultado->resultado_numero)) {
            return (string) $resultado->resultado_numero;
        }

        if (filled($resultado->resultado_texto)) {
            return $resultado->resultado_texto;
        }

        return '-';
    }
}
