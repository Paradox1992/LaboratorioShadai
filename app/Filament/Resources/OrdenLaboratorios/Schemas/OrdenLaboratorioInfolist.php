<?php

namespace App\Filament\Resources\OrdenLaboratorios\Schemas;

use App\Models\OrdenLaboratorio;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrdenLaboratorioInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ventanillaOrden.id')
                    ->label('Ventanilla orden')
                    ->placeholder('-'),
                TextEntry::make('paciente.id')
                    ->label('Paciente'),
                TextEntry::make('usuario.id')
                    ->label('Usuario')
                    ->placeholder('-'),
                TextEntry::make('fecha_orden')
                    ->dateTime(),
                TextEntry::make('fecha_toma_muestra')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('fecha_entrega_estimada')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('fecha_finalizacion')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('estado'),
                TextEntry::make('prioridad'),
                TextEntry::make('diagnostico_presuntivo')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('medico_solicitante')
                    ->placeholder('-'),
                TextEntry::make('observacion')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('resultado_impreso')
                    ->boolean(),
                TextEntry::make('fecha_resultado_impreso')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('cantidad_impresiones_resultado')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (OrdenLaboratorio $record): bool => $record->trashed()),
            ]);
    }
}
