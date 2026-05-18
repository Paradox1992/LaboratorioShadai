<?php

namespace App\Filament\Resources\Pacientes;

use App\Filament\Resources\Pacientes\Pages\CreatePaciente;
use App\Filament\Resources\Pacientes\Pages\EditPaciente;
use App\Filament\Resources\Pacientes\Pages\ListPacientes;
use App\Filament\Resources\Pacientes\Pages\ViewPaciente;
use App\Filament\Resources\Pacientes\Schemas\PacienteForm;
use App\Filament\Resources\Pacientes\Schemas\PacienteInfolist;
use App\Filament\Resources\Pacientes\Tables\PacientesTable;
use App\Models\Paciente;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class PacienteResource extends Resource
{
    protected static ?string $model = Paciente::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = '02. Operacion clinica';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Pacientes';

    protected static ?string $modelLabel = 'paciente';

    protected static ?string $pluralModelLabel = 'pacientes';

    public static function form(Schema $schema): Schema
    {
        return PacienteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PacienteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PacientesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPacientes::route('/'),
            'create' => CreatePaciente::route('/create'),
            'view' => ViewPaciente::route('/{record}'),
            'edit' => EditPaciente::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
