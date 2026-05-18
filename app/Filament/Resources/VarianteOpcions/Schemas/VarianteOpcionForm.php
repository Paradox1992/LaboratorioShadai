<?php

namespace App\Filament\Resources\VarianteOpcions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VarianteOpcionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('variante_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Variante a la que pertenece esta opcion seleccionable.')
                    ->relationship('variante', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('valor')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Valor que se podra seleccionar al capturar el resultado.')
                    ->required(),
                TextInput::make('descripcion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Descripcion o significado de esta opcion.'),
                Toggle::make('es_normal')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Marca si esta opcion representa un resultado normal.'),
                TextInput::make('orden')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Orden en que aparecera esta opcion.')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Permite usar u ocultar esta opcion.')
                    ->required(),
            ]);
    }
}
