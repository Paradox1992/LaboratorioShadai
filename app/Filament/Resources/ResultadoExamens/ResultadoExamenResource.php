<?php

namespace App\Filament\Resources\ResultadoExamens;

use App\Filament\Resources\ResultadoExamens\Pages\CreateResultadoExamen;
use App\Filament\Resources\ResultadoExamens\Pages\EditResultadoExamen;
use App\Filament\Resources\ResultadoExamens\Pages\ListResultadoExamens;
use App\Filament\Resources\ResultadoExamens\Pages\ViewResultadoExamen;
use App\Filament\Resources\ResultadoExamens\Schemas\ResultadoExamenForm;
use App\Filament\Resources\ResultadoExamens\Schemas\ResultadoExamenInfolist;
use App\Filament\Resources\ResultadoExamens\Tables\ResultadoExamensTable;
use App\Models\ResultadoExamen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ResultadoExamenResource extends Resource
{
    protected static ?string $model = ResultadoExamen::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;

    protected static string|UnitEnum|null $navigationGroup = '03. Resultados';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Resultados de examenes';

    protected static ?string $modelLabel = 'resultado de examen';

    protected static ?string $pluralModelLabel = 'resultados de examenes';

    public static function form(Schema $schema): Schema
    {
        return ResultadoExamenForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ResultadoExamenInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResultadoExamensTable::configure($table);
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
            'index' => ListResultadoExamens::route('/'),
            'create' => CreateResultadoExamen::route('/create'),
            'view' => ViewResultadoExamen::route('/{record}'),
            'edit' => EditResultadoExamen::route('/{record}/edit'),
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
