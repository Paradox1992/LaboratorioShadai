<?php

namespace App\Filament\Resources\UnidadMedidas;

use App\Filament\Resources\UnidadMedidas\Pages\CreateUnidadMedida;
use App\Filament\Resources\UnidadMedidas\Pages\EditUnidadMedida;
use App\Filament\Resources\UnidadMedidas\Pages\ListUnidadMedidas;
use App\Filament\Resources\UnidadMedidas\Pages\ViewUnidadMedida;
use App\Filament\Resources\UnidadMedidas\Schemas\UnidadMedidaForm;
use App\Filament\Resources\UnidadMedidas\Schemas\UnidadMedidaInfolist;
use App\Filament\Resources\UnidadMedidas\Tables\UnidadMedidasTable;
use App\Models\UnidadMedida;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class UnidadMedidaResource extends Resource
{
    protected static ?string $model = UnidadMedida::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static string|UnitEnum|null $navigationGroup = '01. Catalogos de laboratorio';

    protected static ?int $navigationSort = 30;

    protected static ?string $navigationLabel = 'Unidades de medida';

    protected static ?string $modelLabel = 'unidad de medida';

    protected static ?string $pluralModelLabel = 'unidades de medida';

    public static function form(Schema $schema): Schema
    {
        return UnidadMedidaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UnidadMedidaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnidadMedidasTable::configure($table);
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
            'index' => ListUnidadMedidas::route('/'),
            'create' => CreateUnidadMedida::route('/create'),
            'view' => ViewUnidadMedida::route('/{record}'),
            'edit' => EditUnidadMedida::route('/{record}/edit'),
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
