<?php

namespace App\Filament\Resources\VarianteOpcions;

use App\Filament\Resources\VarianteOpcions\Pages\CreateVarianteOpcion;
use App\Filament\Resources\VarianteOpcions\Pages\EditVarianteOpcion;
use App\Filament\Resources\VarianteOpcions\Pages\ListVarianteOpcions;
use App\Filament\Resources\VarianteOpcions\Pages\ViewVarianteOpcion;
use App\Filament\Resources\VarianteOpcions\Schemas\VarianteOpcionForm;
use App\Filament\Resources\VarianteOpcions\Schemas\VarianteOpcionInfolist;
use App\Filament\Resources\VarianteOpcions\Tables\VarianteOpcionsTable;
use App\Models\VarianteOpcion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class VarianteOpcionResource extends Resource
{
    protected static ?string $model = VarianteOpcion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static string|UnitEnum|null $navigationGroup = '01. Catalogos de laboratorio';

    protected static ?int $navigationSort = 70;

    protected static ?string $navigationLabel = 'Opciones de variantes';

    protected static ?string $modelLabel = 'opcion de variante';

    protected static ?string $pluralModelLabel = 'opciones de variantes';

    public static function form(Schema $schema): Schema
    {
        return VarianteOpcionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VarianteOpcionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VarianteOpcionsTable::configure($table);
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
            'index' => ListVarianteOpcions::route('/'),
            'create' => CreateVarianteOpcion::route('/create'),
            'view' => ViewVarianteOpcion::route('/{record}'),
            'edit' => EditVarianteOpcion::route('/{record}/edit'),
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
