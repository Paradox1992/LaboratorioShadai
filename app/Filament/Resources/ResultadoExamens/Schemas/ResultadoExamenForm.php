<?php

namespace App\Filament\Resources\ResultadoExamens\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ResultadoExamenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('orden_examen_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Examen de una orden al que pertenece este resultado.')
                    ->relationship('ordenExamen', 'id')
                    ->required(),
                Select::make('variante_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Parametro o variante que se esta reportando.')
                    ->relationship('variante', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('valor_referencia_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Valor de referencia usado para interpretar el resultado.')
                    ->relationship('valorReferencia', 'id'),
                TextInput::make('resultado_numero')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Resultado numerico capturado para el parametro.')
                    ->numeric(),
                TextInput::make('resultado_texto')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Resultado textual cuando no aplica un valor numerico.'),
                TextInput::make('unidad')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Unidad mostrada junto al resultado.'),
                TextInput::make('variante_nombre_snapshot')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Copia del nombre de la variante al registrar el resultado.'),
                TextInput::make('ref_nivel_nombre')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombre del nivel de referencia aplicado al resultado.'),
                Select::make('ref_sexo')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Sexo considerado por la referencia aplicada.')
                    ->options([
                        'MASCULINO' => 'Masculino',
                        'FEMENINO' => 'Femenino',
                        'AMBOS' => 'Ambos',
                    ]),
                TextInput::make('ref_operador')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Operador de comparacion usado por la referencia.'),
                TextInput::make('ref_valor_min')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Valor minimo de referencia copiado al resultado.')
                    ->numeric(),
                TextInput::make('ref_valor_max')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Valor maximo de referencia copiado al resultado.')
                    ->numeric(),
                TextInput::make('ref_valor_texto')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Texto de referencia copiado cuando no es numerica.'),
                TextInput::make('ref_unidad')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Unidad de referencia copiada al resultado.'),
                Select::make('estado_resultado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Clasificacion interpretativa del resultado.')
                    ->options([
                        'BAJO' => 'Bajo',
                        'NORMAL' => 'Normal',
                        'ALTO' => 'Alto',
                        'ANORMAL' => 'Anormal',
                        'POSITIVO' => 'Positivo',
                        'NEGATIVO' => 'Negativo',
                        'SIN_CLASIFICAR' => 'Sin clasificar',
                    ])
                    ->required()
                    ->default('SIN_CLASIFICAR'),
                Select::make('validado_por')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Usuario responsable de validar el resultado.')
                    ->relationship('validador', 'usuario')
                    ->searchable()
                    ->preload(),
                DateTimePicker::make('fecha_validacion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Fecha y hora en que el resultado fue validado.'),
                Textarea::make('observacion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Observaciones tecnicas o clinicas del resultado.')
                    ->columnSpanFull(),
            ]);
    }
}
