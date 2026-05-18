<?php

namespace App\Filament\Resources\OrdenLaboratorios\Schemas;

use App\Models\Paciente;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrdenLaboratorioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ventanilla_orden_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Orden de ventanilla que origina esta orden de laboratorio.')
                    ->relationship('ventanillaOrden', 'id'),
                Select::make('paciente_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Paciente al que pertenece la orden de laboratorio.')
                    ->relationship('paciente', 'nombres')
                    ->getOptionLabelFromRecordUsing(fn (Paciente $record): string => filled($record->docid)
                        ? "{$record->nombre_completo} - {$record->docid}"
                        : $record->nombre_completo)
                    ->searchable(['nombres', 'apellidos', 'docid'])
                    ->preload()
                    ->required(),
                Select::make('usuario_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Usuario que registra o gestiona la orden.')
                    ->relationship('usuario', 'usuario')
                    ->searchable()
                    ->preload(),
                DateTimePicker::make('fecha_orden')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Fecha y hora en que se crea la orden.')
                    ->required(),
                DateTimePicker::make('fecha_toma_muestra')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Fecha y hora en que se toma o recibe la muestra.'),
                DateTimePicker::make('fecha_entrega_estimada')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Fecha estimada para entregar los resultados.'),
                DateTimePicker::make('fecha_finalizacion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Fecha en que se finaliza el procesamiento de la orden.'),
                Select::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Estado actual del flujo de laboratorio.')
                    ->options([
                        'PENDIENTE' => 'Pendiente',
                        'TOMA_MUESTRA' => 'Toma de muestra',
                        'EN_PROCESO' => 'En proceso',
                        'FINALIZADA' => 'Finalizada',
                        'ENTREGADA' => 'Entregada',
                        'ANULADA' => 'Anulada',
                    ])
                    ->required()
                    ->default('PENDIENTE'),
                Select::make('prioridad')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Prioridad clinica u operativa de la orden.')
                    ->options([
                        'NORMAL' => 'Normal',
                        'URGENTE' => 'Urgente',
                    ])
                    ->required()
                    ->default('NORMAL'),
                Textarea::make('diagnostico_presuntivo')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Diagnostico o sospecha clinica indicada por el solicitante.')
                    ->columnSpanFull(),
                TextInput::make('medico_solicitante')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Medico o profesional que solicita los examenes.'),
                Textarea::make('observacion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Notas internas o indicaciones adicionales de la orden.')
                    ->columnSpanFull(),
                Toggle::make('resultado_impreso')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Indica si los resultados de esta orden ya fueron impresos.')
                    ->required(),
                DateTimePicker::make('fecha_resultado_impreso')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Fecha y hora de la ultima impresion de resultados.'),
                TextInput::make('cantidad_impresiones_resultado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Cantidad de impresiones realizadas del resultado.')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
