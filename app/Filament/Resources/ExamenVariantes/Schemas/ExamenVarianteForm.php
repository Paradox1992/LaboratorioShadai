<?php

namespace App\Filament\Resources\ExamenVariantes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExamenVarianteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('examen_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Examen al que pertenece esta variante o parametro.')
                    ->relationship('examen', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('unidad_medida_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Unidad de medida predeterminada para esta variante.')
                    ->relationship('unidadMedida', 'simbolo')
                    ->searchable()
                    ->preload(),
                TextInput::make('nombre')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombre del parametro que se capturara como resultado.')
                    ->required(),
                TextInput::make('descripcion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Descripcion corta sobre que mide o representa esta variante.'),
                Select::make('tipo_resultado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Define como se captura el resultado: numero, texto, seleccion u observacion.')
                    ->options([
                        'NUMERICO' => 'Numerico',
                        'TEXTO' => 'Texto',
                        'SELECT' => 'Seleccion',
                        'POSITIVO_NEGATIVO' => 'Positivo / negativo',
                        'MULTIPLE' => 'Multiple',
                        'OBSERVACION' => 'Observacion',
                    ])
                    ->required()
                    ->default('NUMERICO'),
                TextInput::make('unidad_manual')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Unidad escrita manualmente cuando no esta en el catalogo.'),
                Toggle::make('permite_decimales')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Indica si el resultado numerico puede tener decimales.')
                    ->required(),
                TextInput::make('decimales')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Cantidad de decimales permitidos para resultados numericos.')
                    ->required()
                    ->numeric()
                    ->default(2),
                Toggle::make('obligatorio')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Indica si este parametro debe llenarse para completar el examen.')
                    ->required(),
                TextInput::make('orden')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Orden visual del parametro dentro del examen.')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Permite usar u ocultar esta variante sin eliminarla.')
                    ->required(),
            ]);
    }
}
