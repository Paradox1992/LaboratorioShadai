<?php

namespace App\Filament\Resources\AuditoriaEventos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AuditoriaEventoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('usuario.id')
                    ->label('Usuario')
                    ->placeholder('-'),
                TextEntry::make('tabla'),
                TextEntry::make('registro_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('accion'),
                TextEntry::make('descripcion')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('valor_anterior')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('valor_nuevo')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('ip')
                    ->placeholder('-'),
                TextEntry::make('user_agent')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
