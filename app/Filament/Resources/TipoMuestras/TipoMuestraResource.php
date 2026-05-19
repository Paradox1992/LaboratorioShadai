<?php

namespace App\Filament\Resources\TipoMuestras;

use App\Filament\Resources\Concerns\AuthorizesResourceAccess;
use App\Filament\Resources\TipoMuestras\Pages\CreateTipoMuestra;
use App\Filament\Resources\TipoMuestras\Pages\EditTipoMuestra;
use App\Filament\Resources\TipoMuestras\Pages\ListTipoMuestras;
use App\Filament\Resources\TipoMuestras\Pages\ViewTipoMuestra;
use App\Filament\Resources\TipoMuestras\Schemas\TipoMuestraForm;
use App\Filament\Resources\TipoMuestras\Schemas\TipoMuestraInfolist;
use App\Filament\Resources\TipoMuestras\Tables\TipoMuestrasTable;
use App\Models\TipoMuestra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class TipoMuestraResource extends Resource
{
    use AuthorizesResourceAccess;

    protected static ?string $model = TipoMuestra::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;

    protected static string|UnitEnum|null $navigationGroup = '01. Catalogos de laboratorio';

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationLabel = 'Tipos de muestra';

    protected static ?string $modelLabel = 'tipo de muestra';

    protected static ?string $pluralModelLabel = 'tipos de muestra';

    public static function form(Schema $schema): Schema
    {
        return TipoMuestraForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TipoMuestraInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TipoMuestrasTable::configure($table);
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
            'index' => ListTipoMuestras::route('/'),
            'create' => CreateTipoMuestra::route('/create'),
            'view' => ViewTipoMuestra::route('/{record}'),
            'edit' => EditTipoMuestra::route('/{record}/edit'),
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
