<?php

namespace App\Http\Controllers;

use App\Models\RegisteredDevice;
use App\Models\User;
use App\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TemporaryDeviceTokenController extends Controller
{
    public function create(): View
    {
        return view('security.device-token');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'soporte_usuario' => ['required', 'string'],
            'soporte_password' => ['required', 'string'],
            'nombre' => ['required', 'string', 'max:150'],
            'usuario' => ['nullable', 'string', 'exists:usuarios_sistema,usuario'],
        ]);

        $supportUser = User::query()
            ->where('usuario', $data['soporte_usuario'])
            ->where('estado', true)
            ->first();

        if (! $supportUser || $supportUser->role() !== UserRole::Soporte || ! Hash::check($data['soporte_password'], (string) $supportUser->password)) {
            return back()
                ->withErrors(['soporte_usuario' => 'Las credenciales de soporte no son validas.'])
                ->withInput($request->except('soporte_password'));
        }

        $token = Str::random(64);
        $userId = filled($data['usuario'] ?? null)
            ? User::query()->where('usuario', $data['usuario'])->value('id')
            : null;

        RegisteredDevice::create([
            'usuario_id' => $userId,
            'nombre' => $data['nombre'],
            'registro_token_hash' => hash('sha256', $token),
            'estado' => true,
        ]);

        return redirect()
            ->route('temporary-device-token.create')
            ->withInput($request->only('nombre', 'usuario', 'soporte_usuario'))
            ->with('registration_url', url('/registrar-dispositivo/'.$token));
    }
}
