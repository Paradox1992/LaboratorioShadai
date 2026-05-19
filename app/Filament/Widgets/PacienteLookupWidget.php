<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Pacientes\PacienteResource;
use App\Models\Paciente;
use App\Models\User;
use App\UserRole;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class PacienteLookupWidget extends TableWidget
{
    protected static ?string $heading = 'Verificar paciente';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -10;

    protected static bool $isLazy = false;

    public static function canView(): bool
    {
        $user = auth()->user();

        return $user instanceof User
            && in_array($user->role(), [UserRole::User, UserRole::Soporte], true);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Paciente::query()
                ->when(blank($this->tableSearch), fn (Builder $query): Builder => $query->whereRaw('1 = 0'))
                ->latest('updated_at'))
            ->searchPlaceholder('Buscar por documento, nombres o apellidos')
            ->columns([
                TextColumn::make('docid')
                    ->label('Documento')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('nombre_completo')
                    ->label('Paciente')
                    ->state(fn (Paciente $record): string => $record->nombre_completo)
                    ->searchable(['nombres', 'apellidos'])
                    ->description(fn (Paciente $record): ?string => $record->telefono),
                TextColumn::make('sexo')
                    ->badge()
                    ->searchable(),
                TextColumn::make('fecha_nacimiento')
                    ->label('Nacimiento')
                    ->date('d/m/Y')
                    ->sortable(),
                IconColumn::make('estado')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->emptyStateHeading('Sin coincidencias')
            ->emptyStateDescription('Escribe el documento, nombres o apellidos para verificar si el paciente existe.')
            ->paginated([5, 10])
            ->recordActions([
                Action::make('open')
                    ->label('Abrir')
                    ->icon(Heroicon::OutlinedEye)
                    ->url(fn (Paciente $record): string => PacienteResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
