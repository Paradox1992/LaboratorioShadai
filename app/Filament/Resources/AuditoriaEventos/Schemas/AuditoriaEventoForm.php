<?php

namespace App\Filament\Resources\AuditoriaEventos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AuditoriaEventoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('usuario_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Usuario que realizo la accion auditada.')
                    ->relationship('usuario', 'usuario')
                    ->searchable()
                    ->preload(),
                TextInput::make('tabla')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Tabla o modulo donde ocurrio el evento.')
                    ->required(),
                TextInput::make('registro_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Identificador del registro afectado por la accion.')
                    ->numeric(),
                Select::make('accion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Tipo de accion realizada sobre el registro.')
                    ->options([
                        'CREAR' => 'Crear',
                        'ACTUALIZAR' => 'Actualizar',
                        'ELIMINAR' => 'Eliminar',
                        'ANULAR' => 'Anular',
                        'VALIDAR' => 'Validar',
                        'IMPRIMIR' => 'Imprimir',
                        'ENTREGAR' => 'Entregar',
                    ])
                    ->required(),
                Textarea::make('descripcion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Detalle legible de lo que ocurrio.')
                    ->columnSpanFull(),
                Textarea::make('valor_anterior')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Datos previos del registro antes del cambio.')
                    ->columnSpanFull(),
                Textarea::make('valor_nuevo')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Datos nuevos del registro despues del cambio.')
                    ->columnSpanFull(),
                TextInput::make('ip')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Direccion IP desde donde se realizo la accion.'),
                Textarea::make('user_agent')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Navegador o cliente usado al realizar la accion.')
                    ->columnSpanFull(),
            ]);
    }
}
