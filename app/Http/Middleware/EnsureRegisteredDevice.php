<?php

namespace App\Http\Middleware;

use App\Security\DeviceJwtManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRegisteredDevice
{
    public function handle(Request $request, Closure $next): Response
    {
        $encryptedToken = $request->cookie(config('shadai.device_cookie'));

        if (blank($encryptedToken)) {
            abort(403, 'Este dispositivo no esta registrado para acceder al sistema.');
        }

        $device = app(DeviceJwtManager::class)->deviceFromEncryptedToken($encryptedToken, $request);

        if (! $device) {
            abort(403, 'El token de este dispositivo no es valido, expiro o fue revocado.');
        }

        $device->forceFill(['ultimo_acceso_at' => now()])->save();

        return $next($request);
    }
}
