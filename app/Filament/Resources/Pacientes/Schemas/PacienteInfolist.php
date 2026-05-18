<?php

namespace App\Filament\Resources\Pacientes\Schemas;

use App\Models\Paciente;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PacienteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('docid')
                    ->label('Documento')
                    ->placeholder('-'),
                TextEntry::make('nombres'),
                TextEntry::make('apellidos'),
                TextEntry::make('sexo')
                    ->placeholder('-'),
                TextEntry::make('telefono')
                    ->placeholder('-'),
                TextEntry::make('correo')
                    ->placeholder('-'),
                TextEntry::make('direccion')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('contacto_emergencia_nombre')
                    ->placeholder('-'),
                TextEntry::make('contacto_emergencia_telefono')
                    ->placeholder('-'),
                TextEntry::make('alergias')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('enfermedades_base')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
                    ->visible(fn (Paciente $record): bool => $record->trashed()),
            ]);
    }
}
