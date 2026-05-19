<?php

namespace App\Filament\Resources\OrdenLaboratorios\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class OrdenLaboratoriosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ventanillaOrden.id')
                    ->searchable(),
                TextColumn::make('paciente.id')
                    ->searchable(),
                TextColumn::make('usuario.id')
                    ->searchable(),
                TextColumn::make('fecha_orden')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('fecha_toma_muestra')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('fecha_entrega_estimada')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('fecha_finalizacion')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('estado')
                    ->searchable(),
                TextColumn::make('prioridad')
                    ->searchable(),
                TextColumn::make('medico_solicitante')
                    ->searchable(),
                IconColumn::make('resultado_impreso')
                    ->boolean(),
                TextColumn::make('fecha_resultado_impreso')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('cantidad_impresiones_resultado')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('imprimirResultados')
                    ->label('Resultados')
                    ->icon('heroicon-o-document-text')
                    ->url(fn ($record): string => route('resultados.imprimir', $record))
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
