<?php

namespace App\Filament\Resources\AuditoriaEventos;

use App\Filament\Resources\AuditoriaEventos\Pages\CreateAuditoriaEvento;
use App\Filament\Resources\AuditoriaEventos\Pages\EditAuditoriaEvento;
use App\Filament\Resources\AuditoriaEventos\Pages\ListAuditoriaEventos;
use App\Filament\Resources\AuditoriaEventos\Pages\ViewAuditoriaEvento;
use App\Filament\Resources\AuditoriaEventos\Schemas\AuditoriaEventoForm;
use App\Filament\Resources\AuditoriaEventos\Schemas\AuditoriaEventoInfolist;
use App\Filament\Resources\AuditoriaEventos\Tables\AuditoriaEventosTable;
use App\Models\AuditoriaEvento;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AuditoriaEventoResource extends Resource
{
    protected static ?string $model = AuditoriaEvento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|UnitEnum|null $navigationGroup = '04. Administracion';

    protected static ?int $navigationSort = 40;

    protected static ?string $navigationLabel = 'Auditoria';

    protected static ?string $modelLabel = 'evento de auditoria';

    protected static ?string $pluralModelLabel = 'eventos de auditoria';

    public static function form(Schema $schema): Schema
    {
        return AuditoriaEventoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AuditoriaEventoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuditoriaEventosTable::configure($table);
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
            'index' => ListAuditoriaEventos::route('/'),
            'create' => CreateAuditoriaEvento::route('/create'),
            'view' => ViewAuditoriaEvento::route('/{record}'),
            'edit' => EditAuditoriaEvento::route('/{record}/edit'),
        ];
    }
}
