<?php

namespace App\Filament\Resources\TipoMuestras\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TipoMuestraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Tipo de muestra requerida para uno o varios examenes.')
                    ->required(),
                TextInput::make('descripcion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Indicaciones o detalle adicional del tipo de muestra.'),
                Toggle::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Permite usar u ocultar este tipo de muestra.')
                    ->required(),
            ]);
    }
}
