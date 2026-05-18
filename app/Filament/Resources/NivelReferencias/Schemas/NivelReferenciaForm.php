<?php

namespace App\Filament\Resources\NivelReferencias\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NivelReferenciaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombre del rango de edad usado para valores de referencia.')
                    ->required(),
                TextInput::make('descripcion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Explicacion breve del nivel de referencia.'),
                TextInput::make('edad_min_dias')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Edad minima en dias para aplicar este nivel.')
                    ->numeric(),
                TextInput::make('edad_max_dias')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Edad maxima en dias para aplicar este nivel; puede quedar vacia si no hay limite.')
                    ->numeric(),
                Toggle::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Permite usar u ocultar este nivel de referencia.')
                    ->required(),
            ]);
    }
}
