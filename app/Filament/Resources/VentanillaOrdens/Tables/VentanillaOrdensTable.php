<?php

namespace App\Filament\Resources\VentanillaOrdens\Tables;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VentanillaOrdensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query
                ->with(['ordenLaboratorio.examenesOrdenados.resultados', 'paciente']))
            ->columns([
                TextColumn::make('paciente.nombre_completo')
                    ->label('Cliente')
                    ->searchable(),
                TextColumn::make('examenes')
                    ->state(fn ($record): int => $record->ordenLaboratorio?->examenesOrdenados
                        ->sum(fn ($ordenExamen): int => $ordenExamen->resultados->count()) ?? 0)
                    ->label('Examenes'),
                TextColumn::make('observacion')
                    ->placeholder('-')
                    ->limit(40),
                TextColumn::make('fecha_recepcion')
                    ->label('Fecha recepcion')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Creada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('fecha_recepcion')
                    ->label('Rango de fechas')
                    ->schema([
                        DatePicker::make('desde')
                            ->label('Desde')
                            ->default(today()),
                        DatePicker::make('hasta')
                            ->label('Hasta')
                            ->default(today()),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['desde'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('fecha_recepcion', '>=', $date),
                        )
                        ->when(
                            $data['hasta'] ?? null,
                            fn (Builder $query, string $date): Builder => $query->whereDate('fecha_recepcion', '<=', $date),
                        ))
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['desde'] ?? null) {
                            $indicators[] = Indicator::make('Desde '.Carbon::parse($data['desde'])->toDateString())
                                ->removeField('desde');
                        }

                        if ($data['hasta'] ?? null) {
                            $indicators[] = Indicator::make('Hasta '.Carbon::parse($data['hasta'])->toDateString())
                                ->removeField('hasta');
                        }

                        return $indicators;
                    })
                    ->default(),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('imprimirResultados')
                    ->label('Imprimir')
                    ->icon('heroicon-o-printer')
                    ->url(fn ($record): ?string => $record->ordenLaboratorio
                        ? route('resultados.imprimir', $record->ordenLaboratorio)
                        : null)
                    ->visible(fn ($record): bool => filled($record->ordenLaboratorio))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
