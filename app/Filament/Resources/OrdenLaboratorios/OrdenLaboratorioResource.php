<?php

namespace App\Filament\Resources\OrdenLaboratorios;

use App\Filament\Resources\OrdenLaboratorios\Pages\CreateOrdenLaboratorio;
use App\Filament\Resources\OrdenLaboratorios\Pages\EditOrdenLaboratorio;
use App\Filament\Resources\OrdenLaboratorios\Pages\ListOrdenLaboratorios;
use App\Filament\Resources\OrdenLaboratorios\Pages\ViewOrdenLaboratorio;
use App\Filament\Resources\OrdenLaboratorios\Schemas\OrdenLaboratorioForm;
use App\Filament\Resources\OrdenLaboratorios\Schemas\OrdenLaboratorioInfolist;
use App\Filament\Resources\OrdenLaboratorios\Tables\OrdenLaboratoriosTable;
use App\Models\OrdenLaboratorio;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class OrdenLaboratorioResource extends Resource
{
    protected static ?string $model = OrdenLaboratorio::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|UnitEnum|null $navigationGroup = '02. Operacion clinica';

    protected static ?int $navigationSort = 30;

    protected static ?string $navigationLabel = 'Ordenes de laboratorio';

    protected static ?string $modelLabel = 'orden de laboratorio';

    protected static ?string $pluralModelLabel = 'ordenes de laboratorio';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return OrdenLaboratorioForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrdenLaboratorioInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdenLaboratoriosTable::configure($table);
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
            'index' => ListOrdenLaboratorios::route('/'),
            'create' => CreateOrdenLaboratorio::route('/create'),
            'view' => ViewOrdenLaboratorio::route('/{record}'),
            'edit' => EditOrdenLaboratorio::route('/{record}/edit'),
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
