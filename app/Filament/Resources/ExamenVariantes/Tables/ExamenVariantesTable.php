<?php

namespace App\Filament\Resources\ExamenVariantes\Tables;

use App\Models\ValorReferencia;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExamenVariantesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with('valoresReferencia.nivel'))
            ->columns([
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('valoresReferencia.nivel.nombre')
                    ->label('Nivel')
                    ->badge(),
                TextColumn::make('valores_referencia')
                    ->label('Valor de referencia')
                    ->state(fn ($record): string => $record->valoresReferencia
                        ->map(fn ($referencia): string => self::referenciaLabel($referencia))
                        ->filter()
                        ->join(', ') ?: '-')
                    ->wrap(),
                TextColumn::make('tipo_resultado')
                    ->searchable(),
                TextColumn::make('unidad_manual')
                    ->searchable(),
                TextColumn::make('decimales')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('orden')
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
