<?php

namespace App\Filament\Resources\ResultadoExamens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ResultadoExamensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ordenExamen.id')
                    ->searchable(),
                TextColumn::make('variante.id')
                    ->searchable(),
                TextColumn::make('valorReferencia.id')
                    ->searchable(),
                TextInputColumn::make('resultado_numero')
                    ->label('Valor numerico')
                    ->type('number')
                    ->rules(['nullable', 'numeric'])
                    ->sortable(),
                TextInputColumn::make('resultado_texto')
                    ->label('Valor textual')
                    ->rules(['nullable', 'string', 'max:500'])
                    ->searchable(),
                TextColumn::make('unidad')
                    ->searchable(),
                TextColumn::make('variante_nombre_snapshot')
                    ->searchable(),
                TextColumn::make('ref_nivel_nombre')
                    ->searchable(),
                TextColumn::make('ref_sexo')
                    ->searchable(),
                TextColumn::make('ref_operador')
                    ->searchable(),
                TextColumn::make('ref_valor_min')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ref_valor_max')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ref_valor_texto')
                    ->searchable(),
                TextColumn::make('ref_unidad')
                    ->searchable(),
                TextColumn::make('estado_resultado')
                    ->searchable(),
                TextColumn::make('validado_por')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fecha_validacion')
                    ->dateTime()
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
                DeleteAction::make(),
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
