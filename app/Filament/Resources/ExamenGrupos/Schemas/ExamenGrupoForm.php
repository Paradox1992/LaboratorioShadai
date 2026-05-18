<?php

namespace App\Filament\Resources\ExamenGrupos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExamenGrupoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombre del grupo que clasifica examenes relacionados.')
                    ->required(),
                TextInput::make('descripcion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Detalle breve sobre que examenes pertenecen a este grupo.'),
                TextInput::make('orden')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Posicion en la que se mostrara este grupo en listas y reportes.')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Permite usar u ocultar este grupo sin eliminarlo.')
                    ->required(),
            ]);
    }
}
