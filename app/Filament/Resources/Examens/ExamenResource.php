<?php

namespace App\Filament\Resources\Examens;

use App\Filament\Resources\Concerns\AuthorizesResourceAccess;
use App\Filament\Resources\Examens\Pages\CreateExamen;
use App\Filament\Resources\Examens\Pages\EditExamen;
use App\Filament\Resources\Examens\Pages\ListExamens;
use App\Filament\Resources\Examens\Pages\ViewExamen;
use App\Filament\Resources\Examens\Schemas\ExamenForm;
use App\Filament\Resources\Examens\Schemas\ExamenInfolist;
use App\Filament\Resources\Examens\Tables\ExamensTable;
use App\Models\Examen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ExamenResource extends Resource
{
    use AuthorizesResourceAccess;

    protected static ?string $model = Examen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = '01. Catalogos de laboratorio';

    protected static ?int $navigationSort = 50;

    protected static ?string $navigationLabel = 'Examenes';

    protected static ?string $modelLabel = 'examen';

    protected static ?string $pluralModelLabel = 'examenes';

    public static function form(Schema $schema): Schema
    {
        return ExamenForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExamenInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamensTable::configure($table);
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
            'index' => ListExamens::route('/'),
            'create' => CreateExamen::route('/create'),
            'view' => ViewExamen::route('/{record}'),
            'edit' => EditExamen::route('/{record}/edit'),
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
