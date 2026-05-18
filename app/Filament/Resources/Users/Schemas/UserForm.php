<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombre completo del usuario del sistema.')
                    ->required(),
                TextInput::make('usuario')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombre de usuario usado para iniciar sesion.')
                    ->required(),
                TextInput::make('correo')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Correo de contacto del usuario.'),
                TextInput::make('password')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Contrasena de acceso; en edicion dejala vacia para conservar la actual.')
                    ->password()
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                TextInput::make('rol')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Rol o perfil operativo asignado al usuario.'),
                Toggle::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Permite o bloquea el acceso del usuario al panel.')
                    ->required(),
            ]);
    }
}
