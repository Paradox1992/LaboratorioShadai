<?php

namespace App\Filament\Resources\Examens\Schemas;

use App\Models\Examen;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExamenInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('grupo.nombre')
                    ->label('Grupo'),
                TextEntry::make('tipoMuestra.nombre')
                    ->label('Tipo muestra')
                    ->placeholder('-'),
                TextEntry::make('nombre'),
                TextEntry::make('descripcion')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('requiere_ayuno')
                    ->boolean(),
                IconEntry::make('requiere_muestra')
                    ->boolean(),
                TextEntry::make('tiempo_entrega_horas')
                    ->numeric()
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
                    ->visible(fn (Examen $record): bool => $record->trashed()),
            ]);
    }
}
