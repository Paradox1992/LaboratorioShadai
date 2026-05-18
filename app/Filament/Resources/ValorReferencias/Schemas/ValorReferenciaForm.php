<?php

namespace App\Filament\Resources\ValorReferencias\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ValorReferenciaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('variante_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Parametro de examen al que aplica este valor de referencia.')
                    ->relationship('variante', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('nivel_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Rango de edad o grupo poblacional al que aplica la referencia.')
                    ->relationship('nivel', 'nombre')
                    ->searchable()
                    ->preload(),
                Select::make('sexo')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Sexo del paciente para aplicar esta referencia.')
                    ->options([
                        'MASCULINO' => 'Masculino',
                        'FEMENINO' => 'Femenino',
                        'AMBOS' => 'Ambos',
                    ])
                    ->required()
                    ->default('AMBOS'),
                Select::make('operador')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Regla usada para interpretar el resultado frente a la referencia.')
                    ->options([
                        'RANGO' => 'Rango',
                        'MENOR_QUE' => 'Menor que',
                        'MENOR_IGUAL' => 'Menor o igual',
                        'MAYOR_QUE' => 'Mayor que',
                        'MAYOR_IGUAL' => 'Mayor o igual',
                        'IGUAL' => 'Igual',
                        'TEXTO' => 'Texto',
                        'SIN_REFERENCIA' => 'Sin referencia',
                    ])
                    ->required()
                    ->default('RANGO'),
                TextInput::make('valor_min')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Limite minimo normal cuando la referencia es un rango.')
                    ->numeric(),
                TextInput::make('valor_max')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Limite maximo normal cuando la referencia es un rango.')
                    ->numeric(),
                TextInput::make('valor_texto')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Texto esperado cuando la referencia no es numerica.'),
                TextInput::make('unidad')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Unidad que acompana el valor de referencia.'),
                TextInput::make('interpretacion_normal')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Texto de interpretacion cuando el resultado esta dentro de lo esperado.'),
                TextInput::make('observacion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Notas adicionales para esta referencia.'),
                Toggle::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Permite usar u ocultar este valor de referencia.')
                    ->required(),
            ]);
    }
}
