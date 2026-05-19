<?php

namespace App\Filament\Resources\RegisteredDevices;

use App\Filament\Resources\Concerns\AuthorizesResourceAccess;
use App\Filament\Resources\RegisteredDevices\Pages\CreateRegisteredDevice;
use App\Filament\Resources\RegisteredDevices\Pages\EditRegisteredDevice;
use App\Filament\Resources\RegisteredDevices\Pages\ListRegisteredDevices;
use App\Filament\Resources\RegisteredDevices\Pages\ViewRegisteredDevice;
use App\Filament\Resources\RegisteredDevices\Schemas\RegisteredDeviceForm;
use App\Filament\Resources\RegisteredDevices\Schemas\RegisteredDeviceInfolist;
use App\Filament\Resources\RegisteredDevices\Tables\RegisteredDevicesTable;
use App\Models\RegisteredDevice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class RegisteredDeviceResource extends Resource
{
    use AuthorizesResourceAccess;

    protected static ?string $model = RegisteredDevice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;

    protected static string|UnitEnum|null $navigationGroup = '04. Administracion';

    protected static ?int $navigationSort = 30;

    protected static ?string $navigationLabel = 'Dispositivos registrados';

    protected static ?string $modelLabel = 'dispositivo registrado';

    protected static ?string $pluralModelLabel = 'dispositivos registrados';

    public static function form(Schema $schema): Schema
    {
        return RegisteredDeviceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RegisteredDeviceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RegisteredDevicesTable::configure($table);
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
            'index' => ListRegisteredDevices::route('/'),
            'create' => CreateRegisteredDevice::route('/create'),
            'view' => ViewRegisteredDevice::route('/{record}'),
            'edit' => EditRegisteredDevice::route('/{record}/edit'),
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
