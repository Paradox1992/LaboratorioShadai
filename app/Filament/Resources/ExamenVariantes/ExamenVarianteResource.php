<?php

namespace App\Filament\Resources\ExamenVariantes;

use App\Filament\Resources\ExamenVariantes\Pages\CreateExamenVariante;
use App\Filament\Resources\ExamenVariantes\Pages\EditExamenVariante;
use App\Filament\Resources\ExamenVariantes\Pages\ListExamenVariantes;
use App\Filament\Resources\ExamenVariantes\Pages\ViewExamenVariante;
use App\Filament\Resources\ExamenVariantes\Schemas\ExamenVarianteForm;
use App\Filament\Resources\ExamenVariantes\Schemas\ExamenVarianteInfolist;
use App\Filament\Resources\ExamenVariantes\Tables\ExamenVariantesTable;
use App\Models\ExamenVariante;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ExamenVarianteResource extends Resource
{
    protected static ?string $model = ExamenVariante::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static string|UnitEnum|null $navigationGroup = '01. Catalogos de laboratorio';

    protected static ?int $navigationSort = 60;

    protected static ?string $navigationLabel = 'Variantes de examenes';

    protected static ?string $modelLabel = 'variante de examen';

    protected static ?string $pluralModelLabel = 'variantes de examenes';

    public static function form(Schema $schema): Schema
    {
        return ExamenVarianteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExamenVarianteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamenVariantesTable::configure($table);
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
            'index' => ListExamenVariantes::route('/'),
            'create' => CreateExamenVariante::route('/create'),
            'view' => ViewExamenVariante::route('/{record}'),
            'edit' => EditExamenVariante::route('/{record}/edit'),
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
