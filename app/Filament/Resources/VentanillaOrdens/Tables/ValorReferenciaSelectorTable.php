<?php

namespace App\Filament\Resources\VentanillaOrdens\Tables;

use App\Models\ValorReferencia;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ValorReferenciaSelectorTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => ValorReferencia::query()
                ->with(['nivel', 'variante'])
                ->where('estado', true)
                ->whereHas('variante', fn (Builder $query): Builder => $query
                    ->where('estado', true)
                    ->whereHas('examen', fn (Builder $query): Builder => $query->where('estado', true))))
            ->columns([
                TextColumn::make('variante.nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nivel.nombre')
                    ->label('Nombre del nivel')
                    ->state(fn (ValorReferencia $record): string => $record->nivel?->nombre ?? '-')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sexo')
                    ->label('Sexo'),
                TextColumn::make('referencia')
                    ->label('Referencia')
                    ->state(fn (ValorReferencia $record): string => self::referenciaLabel($record)),
            ])
            ->defaultSort('id');
    }

    private static function referenciaLabel(ValorReferencia $record): string
    {
        if (filled($record->valor_texto)) {
            return $record->valor_texto;
        }

        $min = $record->valor_min;
        $max = $record->valor_max;
        $unidad = $record->unidad ? " {$record->unidad}" : '';

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
}
