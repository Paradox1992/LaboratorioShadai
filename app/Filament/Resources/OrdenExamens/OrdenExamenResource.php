<?php

namespace App\Filament\Resources\OrdenExamens;

use App\Filament\Resources\Concerns\AuthorizesResourceAccess;
use App\Filament\Resources\OrdenExamens\Pages\CreateOrdenExamen;
use App\Filament\Resources\OrdenExamens\Pages\EditOrdenExamen;
use App\Filament\Resources\OrdenExamens\Pages\ListOrdenExamens;
use App\Filament\Resources\OrdenExamens\Pages\ViewOrdenExamen;
use App\Filament\Resources\OrdenExamens\Schemas\OrdenExamenForm;
use App\Filament\Resources\OrdenExamens\Schemas\OrdenExamenInfolist;
use App\Filament\Resources\OrdenExamens\Tables\OrdenExamensTable;
use App\Models\OrdenExamen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class OrdenExamenResource extends Resource
{
    use AuthorizesResourceAccess;

    protected static ?string $model = OrdenExamen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentDuplicate;

    protected static string|UnitEnum|null $navigationGroup = '02. Operacion clinica';

    protected static ?int $navigationSort = 40;

    protected static ?string $navigationLabel = 'Examenes por orden';

    protected static ?string $modelLabel = 'examen por orden';

    protected static ?string $pluralModelLabel = 'examenes por orden';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return OrdenExamenForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrdenExamenInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdenExamensTable::configure($table);
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
            'index' => ListOrdenExamens::route('/'),
            'create' => CreateOrdenExamen::route('/create'),
            'view' => ViewOrdenExamen::route('/{record}'),
            'edit' => EditOrdenExamen::route('/{record}/edit'),
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
