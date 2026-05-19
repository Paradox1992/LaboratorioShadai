<?php

namespace App\Filament\Resources\VentanillaOrdens;

use App\Filament\Resources\Concerns\AuthorizesResourceAccess;
use App\Filament\Resources\VentanillaOrdens\Pages\CreateVentanillaOrden;
use App\Filament\Resources\VentanillaOrdens\Pages\EditVentanillaOrden;
use App\Filament\Resources\VentanillaOrdens\Pages\ListVentanillaOrdens;
use App\Filament\Resources\VentanillaOrdens\Pages\ViewVentanillaOrden;
use App\Filament\Resources\VentanillaOrdens\Schemas\VentanillaOrdenForm;
use App\Filament\Resources\VentanillaOrdens\Schemas\VentanillaOrdenInfolist;
use App\Filament\Resources\VentanillaOrdens\Tables\VentanillaOrdensTable;
use App\Models\VentanillaOrden;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class VentanillaOrdenResource extends Resource
{
    use AuthorizesResourceAccess;

    protected static ?string $model = VentanillaOrden::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxStack;

    protected static string|UnitEnum|null $navigationGroup = '02. Operacion clinica';

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationLabel = 'Ventanilla de ordenes';

    protected static ?string $modelLabel = 'Examen';

    protected static ?string $pluralModelLabel = 'Examenes';

    public static function form(Schema $schema): Schema
    {
        return VentanillaOrdenForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VentanillaOrdenInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VentanillaOrdensTable::configure($table);
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
            'index' => ListVentanillaOrdens::route('/'),
            'create' => CreateVentanillaOrden::route('/create'),
            'view' => ViewVentanillaOrden::route('/{record}'),
            'edit' => EditVentanillaOrden::route('/{record}/edit'),
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
