<?php

namespace App\Filament\Resources\RegisteredDevices\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RegisteredDeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('usuario_id')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Usuario asociado al dispositivo autorizado.')
                    ->relationship('usuario', 'usuario')
                    ->searchable()
                    ->preload(),
                TextInput::make('nombre')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombre descriptivo del equipo autorizado.')
                    ->required(),
                Toggle::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Permite o bloquea el acceso desde este dispositivo.')
                    ->required(),
            ]);
    }
}
