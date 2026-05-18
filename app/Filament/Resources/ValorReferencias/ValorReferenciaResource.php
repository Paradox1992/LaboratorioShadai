<?php

namespace App\Filament\Resources\ValorReferencias;

use App\Filament\Resources\ValorReferencias\Pages\CreateValorReferencia;
use App\Filament\Resources\ValorReferencias\Pages\EditValorReferencia;
use App\Filament\Resources\ValorReferencias\Pages\ListValorReferencias;
use App\Filament\Resources\ValorReferencias\Pages\ViewValorReferencia;
use App\Filament\Resources\ValorReferencias\Schemas\ValorReferenciaForm;
use App\Filament\Resources\ValorReferencias\Schemas\ValorReferenciaInfolist;
use App\Filament\Resources\ValorReferencias\Tables\ValorReferenciasTable;
use App\Models\ValorReferencia;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ValorReferenciaResource extends Resource
{
    protected static ?string $model = ValorReferencia::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = '01. Catalogos de laboratorio';

    protected static ?int $navigationSort = 80;

    protected static ?string $navigationLabel = 'Valores de referencia';

    protected static ?string $modelLabel = 'valor de referencia';

    protected static ?string $pluralModelLabel = 'valores de referencia';

    public static function form(Schema $schema): Schema
    {
        return ValorReferenciaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ValorReferenciaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ValorReferenciasTable::configure($table);
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
            'index' => ListValorReferencias::route('/'),
            'create' => CreateValorReferencia::route('/create'),
            'view' => ViewValorReferencia::route('/{record}'),
            'edit' => EditValorReferencia::route('/{record}/edit'),
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
