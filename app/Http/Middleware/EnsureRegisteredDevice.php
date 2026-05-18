<?php

namespace App\Http\Middleware;

use App\Models\RegisteredDevice;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRegisteredDevice
{
    public function handle(Request $request, Closure $next): Response
    {
        $fingerprint = $request->cookie(config('shadai.device_cookie'));

        if (blank($fingerprint)) {
            abort(403, 'Este dispositivo no esta registrado para acceder al sistema.');
        }

        $device = RegisteredDevice::query()
            ->where('fingerprint_hash', hash('sha256', $fingerprint))
            ->where('estado', true)
            ->first();

        if (! $device) {
            abort(403, 'Este dispositivo no esta autorizado o fue desactivado.');
        }

        $device->forceFill(['ultimo_acceso_at' => now()])->save();

        return $next($request);
    }
}
