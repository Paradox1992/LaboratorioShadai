<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Validation\ValidationException;
use SensitiveParameter;

class Login extends BaseLogin
{
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('usuario')
            ->label('Usuario')
            ->required()
            ->autocomplete('username')
            ->autofocus();
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.usuario' => 'Las credenciales no coinciden con nuestros registros o el usuario esta inactivo.',
        ]);
    }

    protected function getCredentialsFromFormData(#[SensitiveParameter] array $data): array
    {
        return [
            'usuario' => $data['usuario'],
            'password' => $data['password'],
        ];
    }
}
