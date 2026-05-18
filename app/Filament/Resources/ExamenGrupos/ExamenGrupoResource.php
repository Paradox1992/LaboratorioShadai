<?php

namespace App\Filament\Resources\ExamenGrupos;

use App\Filament\Resources\ExamenGrupos\Pages\CreateExamenGrupo;
use App\Filament\Resources\ExamenGrupos\Pages\EditExamenGrupo;
use App\Filament\Resources\ExamenGrupos\Pages\ListExamenGrupos;
use App\Filament\Resources\ExamenGrupos\Pages\ViewExamenGrupo;
use App\Filament\Resources\ExamenGrupos\Schemas\ExamenGrupoForm;
use App\Filament\Resources\ExamenGrupos\Schemas\ExamenGrupoInfolist;
use App\Filament\Resources\ExamenGrupos\Tables\ExamenGruposTable;
use App\Models\ExamenGrupo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ExamenGrupoResource extends Resource
{
    protected static ?string $model = ExamenGrupo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static string|UnitEnum|null $navigationGroup = '01. Catalogos de laboratorio';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Grupos de examenes';

    protected static ?string $modelLabel = 'grupo de examenes';

    protected static ?string $pluralModelLabel = 'grupos de examenes';

    public static function form(Schema $schema): Schema
    {
        return ExamenGrupoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExamenGrupoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamenGruposTable::configure($table);
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
            'index' => ListExamenGrupos::route('/'),
            'create' => CreateExamenGrupo::route('/create'),
            'view' => ViewExamenGrupo::route('/{record}'),
            'edit' => EditExamenGrupo::route('/{record}/edit'),
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
