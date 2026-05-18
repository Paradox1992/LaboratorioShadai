<?php

namespace App\Filament\Resources\Pacientes\Schemas;

use App\Models\Paciente;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class PacienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('docid')
                    ->maxLength(13)
                    ->regex('/^\d{1,13}$/')
                    ->unique(table: Paciente::class, column: 'docid')
                    ->required()
                    ->hintIcon('heroicon-o-question-mark-circle', 'Numero de identidad, pasaporte u otro documento del paciente.'),
                TextInput::make('nombres')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombres legales del paciente.')
                    ->maxLength(100)
                    ->regex('/^\p{L}+(?: \p{L}+)*$/u')
                    ->required(),
                TextInput::make('apellidos')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Apellidos legales del paciente.')
                    ->rule(fn (Get $get, ?Paciente $record): Unique => self::uniqueNombreApellidoRule($get, $record))
                    ->required(),
                Select::make('sexo')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Sexo biologico usado para valores de referencia.')
                    ->options([
                        'MASCULINO' => 'Masculino',
                        'FEMENINO' => 'Femenino',
                    ]),
                TextInput::make('telefono')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Telefono principal para contactar al paciente.')
                    ->length(8)
                    ->regex('/^\d{8}$/')
                    ->tel(),
                TextInput::make('correo')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Correo del paciente para contacto o envio de informacion.'),
                Textarea::make('direccion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Direccion de residencia o contacto del paciente.')
                    ->columnSpanFull(),
                TextInput::make('contacto_emergencia_nombre')
                    ->maxLength(50)
                    ->regex('/^\p{L}+(?: \p{L}+)*$/u')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Persona a contactar ante una emergencia.'),
                TextInput::make('contacto_emergencia_telefono')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Telefono de la persona de emergencia.')
                    ->length(8)
                    ->regex('/^\d{8}$/')
                    ->tel(),
                Textarea::make('alergias')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Alergias conocidas relevantes para la atencion.')
                    ->maxLength(200)
                    ->regex('/^\p{L}+(?: \p{L}+)*$/u')
                    ->columnSpanFull(),
                Textarea::make('enfermedades_base')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Condiciones o enfermedades cronicas declaradas.')
                    ->maxLength(200)
                    ->regex('/^\p{L}+(?: \p{L}+)*$/u')
                    ->columnSpanFull(),
                Textarea::make('observacion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Notas generales sobre el paciente.')
                    ->maxLength(200)
                    ->regex('/^\p{L}+(?: \p{L}+)*$/u')
                    ->columnSpanFull(),
            ]);
    }

    private static function uniqueNombreApellidoRule(Get $get, ?Paciente $record): Unique
    {
        return Rule::unique(Paciente::class, 'apellidos')
            ->where(fn (Builder $query): Builder => $query->where('nombres', $get('nombres')))
            ->when($record, fn (Unique $rule): Unique => $rule->ignore($record->getKey()));
    }
}
