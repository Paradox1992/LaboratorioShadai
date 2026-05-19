<?php

namespace App\Filament\Auth;

use App\Security\DeviceJwtManager;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;
use SensitiveParameter;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        $response = parent::authenticate();

        if (! $response) {
            return null;
        }

        $this->issueDeviceTokenForRegisteredDevice();

        return $response;
    }

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

    private function issueDeviceTokenForRegisteredDevice(): void
    {
        $request = request();
        $fingerprint = $request->cookie(config('shadai.device_fingerprint_cookie'));

        if (blank($fingerprint)) {
            return;
        }

        $deviceJwtManager = app(DeviceJwtManager::class);
        $device = $deviceJwtManager->deviceFromFingerprint($fingerprint, $request);

        if (! $device) {
            return;
        }

        Cookie::queue(cookie(
            config('shadai.device_cookie'),
            $deviceJwtManager->issueEncryptedToken($device, $request),
            $deviceJwtManager->ttlMinutes(),
            '/',
            null,
            $request->isSecure(),
            true,
            false,
            'strict',
        ));
    }
}
