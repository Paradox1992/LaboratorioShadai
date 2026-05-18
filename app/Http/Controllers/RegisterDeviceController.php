<?php

namespace App\Http\Controllers;

use App\Models\RegisteredDevice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterDeviceController extends Controller
{
    public function __invoke(Request $request, string $token): RedirectResponse
    {
        $device = RegisteredDevice::query()
            ->where('registro_token_hash', hash('sha256', $token))
            ->where('estado', true)
            ->firstOrFail();

        $fingerprint = Str::random(80);

        $device->forceFill([
            'fingerprint_hash' => hash('sha256', $fingerprint),
            'registro_token_hash' => null,
            'ip_registro' => $request->ip(),
            'user_agent_registro' => $request->userAgent(),
            'registrado_at' => now(),
            'ultimo_acceso_at' => now(),
        ])->save();

        return redirect('/admin/login')
            ->withCookie(cookie(
                config('shadai.device_cookie'),
                $fingerprint,
                60 * 24 * 365 * 5,
                '/',
                null,
                false,
                true,
                false,
                'strict',
            ));
    }
}
