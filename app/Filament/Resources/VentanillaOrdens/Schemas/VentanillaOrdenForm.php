<?php

namespace App\Filament\Resources\VentanillaOrdens\Schemas;

use App\Filament\Resources\VentanillaOrdens\Tables\ValorReferenciaSelectorTable;
use App\Models\Paciente;
use App\Models\ValorReferencia;
use Filament\Actions\Action;
use Filament\Forms\Components\ModalTableSelect;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class VentanillaOrdenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('paciente_id')
                    ->label('Cliente')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Cliente o paciente al que se le tomaran los examenes.')
                    ->relationship('paciente', 'nombres')
                    ->getOptionLabelFromRecordUsing(self::pacienteLabel(...))
                    ->searchable(['nombres', 'apellidos', 'docid'])
                    ->preload()
                    ->live()
                    ->afterStateUpdated(self::fillPacienteFields(...))
                    ->required(),
                TextInput::make('paciente_edad')
                    ->label('Edad')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Edad actual del cliente. Se usara para actualizar su fecha de nacimiento estimada.')
                    ->integer()
                    ->minValue(0)
                    ->maxValue(130)
                    ->dehydrated(fn(string $operation): bool => $operation === 'create')
                    ->visible(fn(string $operation): bool => $operation === 'create'),
                TextInput::make('paciente_telefono')
                    ->label('Telefono')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Telefono actual del cliente. Se guardara en sus datos.')
                    ->length(8)
                    ->regex('/^\d{8}$/')
                    ->tel()
                    ->dehydrated(fn(string $operation): bool => $operation === 'create')
                    ->visible(fn(string $operation): bool => $operation === 'create'),
                Repeater::make('selecciones')
                    ->label('Examenes del dia')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Agrega o elimina variantes de examenes para esta orden.')
                    ->table([
                        TableColumn::make('Variante / nivel')->markAsRequired(),
                        TableColumn::make('Valor resultante'),
                    ])
                    ->schema([
                        ModalTableSelect::make('valor_referencia_id')
                            ->label('Variante / nivel')
                            ->tableConfiguration(ValorReferenciaSelectorTable::class)
                            ->getOptionLabelUsing(fn(mixed $value): ?string => self::referenciaSeleccionadaLabel($value))
                            ->selectAction(fn(Action $action): Action => $action
                                ->label('Buscar')
                                ->modalHeading('Buscar variante de examen')
                                ->modalSubmitActionLabel('Agregar'))
                            ->required(),
                        TextInput::make('resultado')
                            ->label('Valor resultante')
                            ->maxLength(500),
                    ])
                    ->addAction(fn(Action $action): Action => $action->label('Agregar'))
                    ->deleteAction(fn(Action $action): Action => $action->label('Eliminar'))
                    ->defaultItems(1)
                    ->minItems(1)
                    ->required()
                    ->columnSpanFull()
                    ->visible(fn(string $operation): bool => $operation === 'create'),
                Textarea::make('observacion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Notas de recepcion o indicaciones especiales.')
                    ->columnSpanFull(),
            ]);
    }

    private static function pacienteLabel(Paciente $paciente): string
    {
        return filled($paciente->docid)
            ? "{$paciente->nombre_completo} - {$paciente->docid}"
            : $paciente->nombre_completo;
    }

    private static function fillPacienteFields(Set $set, mixed $pacienteId): void
    {
        $paciente = filled($pacienteId)
            ? Paciente::query()->find($pacienteId)
            : null;

        $set('paciente_edad', $paciente?->fecha_nacimiento?->age);
        $set('paciente_telefono', $paciente?->telefono);
    }

    private static function referenciaSeleccionadaLabel(mixed $id): ?string
    {
        if (! $id) {
            return null;
        }

        $referencia = ValorReferencia::query()
            ->with(['nivel', 'variante.examen'])
            ->find($id);

        if (! $referencia) {
            return null;
        }

        return collect([
            $referencia->variante?->nombre,
            $referencia->nivel?->nombre,
            self::referenciaLabel($referencia),
        ])
            ->filter()
            ->join(' - ');
    }

    private static function referenciaLabel(ValorReferencia $referencia): string
    {
        if (filled($referencia->valor_texto)) {
            return $referencia->valor_texto;
        }

        $min = $referencia->valor_min;
        $max = $referencia->valor_max;
        $unidad = $referencia->unidad ? " {$referencia->unidad}" : '';

        if (filled($min) && filled($max)) {
            return "{$min} - {$max}{$unidad}";
        }

        if (filled($min)) {
            return "Desde {$min}{$unidad}";
        }

        if (filled($max)) {
            return "Hasta {$max}{$unidad}";
        }

        return '-';
    }
}
