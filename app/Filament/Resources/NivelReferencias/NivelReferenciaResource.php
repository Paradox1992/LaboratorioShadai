<?php

namespace App\Filament\Resources\NivelReferencias;

use App\Filament\Resources\NivelReferencias\Pages\CreateNivelReferencia;
use App\Filament\Resources\NivelReferencias\Pages\EditNivelReferencia;
use App\Filament\Resources\NivelReferencias\Pages\ListNivelReferencias;
use App\Filament\Resources\NivelReferencias\Pages\ViewNivelReferencia;
use App\Filament\Resources\NivelReferencias\Schemas\NivelReferenciaForm;
use App\Filament\Resources\NivelReferencias\Schemas\NivelReferenciaInfolist;
use App\Filament\Resources\NivelReferencias\Tables\NivelReferenciasTable;
use App\Models\NivelReferencia;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class NivelReferenciaResource extends Resource
{
    protected static ?string $model = NivelReferencia::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static string|UnitEnum|null $navigationGroup = '01. Catalogos de laboratorio';

    protected static ?int $navigationSort = 40;

    protected static ?string $navigationLabel = 'Niveles de referencia';

    protected static ?string $modelLabel = 'nivel de referencia';

    protected static ?string $pluralModelLabel = 'niveles de referencia';

    public static function form(Schema $schema): Schema
    {
        return NivelReferenciaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NivelReferenciaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NivelReferenciasTable::configure($table);
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
            'index' => ListNivelReferencias::route('/'),
            'create' => CreateNivelReferencia::route('/create'),
            'view' => ViewNivelReferencia::route('/{record}'),
            'edit' => EditNivelReferencia::route('/{record}/edit'),
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
