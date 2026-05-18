<?php

namespace App\Filament\Resources\OrdenExamens\Schemas;

use App\Models\OrdenExamen;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrdenExamenInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('orden.id')
                    ->label('Orden'),
                TextEntry::make('examen.id')
                    ->label('Examen'),
                TextEntry::make('nombre_examen_snapshot')
                    ->placeholder('-'),
                TextEntry::make('tipo_muestra_snapshot')
                    ->placeholder('-'),
                IconEntry::make('requiere_ayuno_snapshot')
                    ->boolean(),
                TextEntry::make('tiempo_entrega_horas_snapshot')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('estado'),
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
                    ->visible(fn (OrdenExamen $record): bool => $record->trashed()),
            ]);
    }
}
