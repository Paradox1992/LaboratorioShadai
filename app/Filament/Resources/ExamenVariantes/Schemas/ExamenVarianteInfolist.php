<?php

namespace App\Filament\Resources\ExamenVariantes\Schemas;

use App\Models\ExamenVariante;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExamenVarianteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('examen.id')
                    ->label('Examen'),
                TextEntry::make('unidadMedida.id')
                    ->label('Unidad medida')
                    ->placeholder('-'),
                TextEntry::make('nombre'),
                TextEntry::make('descripcion')
                    ->placeholder('-'),
                TextEntry::make('tipo_resultado'),
                TextEntry::make('unidad_manual')
                    ->placeholder('-'),
                IconEntry::make('permite_decimales')
                    ->boolean(),
                TextEntry::make('decimales')
                    ->numeric(),
                IconEntry::make('obligatorio')
                    ->boolean(),
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
                    ->visible(fn (ExamenVariante $record): bool => $record->trashed()),
            ]);
    }
}
