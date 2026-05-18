<?php

namespace App\Filament\Resources\Examens\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExamenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('grupo_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Grupo principal al que pertenece este examen.')
                    ->relationship('grupo', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('tipo_muestra_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Muestra que normalmente se necesita para procesar el examen.')
                    ->relationship('tipoMuestra', 'nombre')
                    ->searchable()
                    ->preload(),
                TextInput::make('nombre')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombre del examen que vera el personal y aparecera en ordenes.')
                    ->required(),
                Textarea::make('descripcion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Indicaciones generales o descripcion clinica del examen.')
                    ->columnSpanFull(),
                Toggle::make('requiere_ayuno')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Marca si el paciente debe presentarse en ayunas.')
                    ->required(),
                Toggle::make('requiere_muestra')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Marca si el examen requiere toma o entrega de muestra.')
                    ->required(),
                TextInput::make('tiempo_entrega_horas')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Horas estimadas para entregar el resultado.')
                    ->numeric(),
                TextInput::make('orden')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Orden en que se mostrara el examen dentro de su grupo.')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Permite usar u ocultar este examen sin eliminarlo.')
                    ->required(),
            ]);
    }
}
