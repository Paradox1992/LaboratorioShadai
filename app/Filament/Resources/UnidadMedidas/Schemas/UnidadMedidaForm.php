<?php

namespace App\Filament\Resources\UnidadMedidas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UnidadMedidaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('simbolo')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Abreviatura de la unidad que se mostrara junto al resultado.')
                    ->required(),
                TextInput::make('nombre')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombre completo de la unidad de medida.')
                    ->required(),
                TextInput::make('descripcion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Descripcion o uso recomendado de esta unidad.'),
                Toggle::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Permite usar u ocultar esta unidad de medida.')
                    ->required(),
            ]);
    }
}
