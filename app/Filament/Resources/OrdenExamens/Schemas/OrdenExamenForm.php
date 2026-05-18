<?php

namespace App\Filament\Resources\OrdenExamens\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrdenExamenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('orden_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Orden de laboratorio a la que se agrega este examen.')
                    ->relationship('orden', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('examen_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Examen solicitado dentro de la orden.')
                    ->relationship('examen', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('nombre_examen_snapshot')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Copia del nombre del examen al momento de crear la orden.'),
                TextInput::make('tipo_muestra_snapshot')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Copia del tipo de muestra requerido al crear la orden.'),
                Toggle::make('requiere_ayuno_snapshot')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Copia de si el examen requeria ayuno al crear la orden.')
                    ->required(),
                TextInput::make('tiempo_entrega_horas_snapshot')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Copia del tiempo estimado de entrega al crear la orden.')
                    ->numeric(),
                Select::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Estado individual de este examen dentro de la orden.')
                    ->options([
                        'PENDIENTE' => 'Pendiente',
                        'MUESTRA_TOMADA' => 'Muestra tomada',
                        'EN_PROCESO' => 'En proceso',
                        'FINALIZADO' => 'Finalizado',
                        'ANULADO' => 'Anulado',
                    ])
                    ->required()
                    ->default('PENDIENTE'),
                Textarea::make('observacion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Notas especificas para este examen solicitado.')
                    ->columnSpanFull(),
            ]);
    }
}
