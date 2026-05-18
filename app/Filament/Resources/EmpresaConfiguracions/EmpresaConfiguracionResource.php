<?php

namespace App\Filament\Resources\EmpresaConfiguracions;

use App\Filament\Resources\EmpresaConfiguracions\Pages\CreateEmpresaConfiguracion;
use App\Filament\Resources\EmpresaConfiguracions\Pages\EditEmpresaConfiguracion;
use App\Filament\Resources\EmpresaConfiguracions\Pages\ListEmpresaConfiguracions;
use App\Filament\Resources\EmpresaConfiguracions\Pages\ViewEmpresaConfiguracion;
use App\Filament\Resources\EmpresaConfiguracions\Schemas\EmpresaConfiguracionForm;
use App\Filament\Resources\EmpresaConfiguracions\Schemas\EmpresaConfiguracionInfolist;
use App\Filament\Resources\EmpresaConfiguracions\Tables\EmpresaConfiguracionsTable;
use App\Models\EmpresaConfiguracion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class EmpresaConfiguracionResource extends Resource
{
    protected static ?string $model = EmpresaConfiguracion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = '04. Administracion';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Empresa';

    protected static ?string $modelLabel = 'configuracion de empresa';

    protected static ?string $pluralModelLabel = 'configuracion de empresa';

    public static function form(Schema $schema): Schema
    {
        return EmpresaConfiguracionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmpresaConfiguracionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmpresaConfiguracionsTable::configure($table);
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
            'index' => ListEmpresaConfiguracions::route('/'),
            'create' => CreateEmpresaConfiguracion::route('/create'),
            'view' => ViewEmpresaConfiguracion::route('/{record}'),
            'edit' => EditEmpresaConfiguracion::route('/{record}/edit'),
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
