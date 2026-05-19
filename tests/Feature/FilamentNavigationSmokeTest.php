<?php

namespace Tests\Feature;

use App\Models\RegisteredDevice;
use App\Models\User;
use App\Security\DeviceJwtManager;
use App\UserRole;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class FilamentNavigationSmokeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_core_filament_pages_render_for_registered_devices(): void
    {
        $user = User::create([
            'nombre' => 'Recepcion',
            'usuario' => 'recepcion',
            'correo' => 'recepcion@example.com',
            'password' => 'password',
            'rol' => UserRole::Soporte->value,
            'estado' => true,
        ]);

        $fingerprint = 'testing-device';

        $device = RegisteredDevice::create([
            'usuario_id' => $user->id,
            'nombre' => 'Equipo de prueba',
            'fingerprint_hash' => hash('sha256', $fingerprint),
            'registro_token_hash' => hash('sha256', 'token'),
            'ip_registro' => '127.0.0.1',
            'user_agent_registro' => 'PHPUnit',
            'registrado_at' => now(),
            'estado' => true,
        ]);
        $deviceToken = app(DeviceJwtManager::class)->issueEncryptedToken($device, Request::create('/'));

        foreach ($this->corePanelPaths() as $path) {
            $this
                ->actingAs($user)
                ->withCookie(config('shadai.device_cookie'), $deviceToken)
                ->get($path)
                ->assertOk();
        }
    }

    /**
     * @return array<int, string>
     */
    private function corePanelPaths(): array
    {
        return [
            '/admin',
            '/admin/pacientes',
            '/admin/ventanilla-ordens',
            '/admin/orden-laboratorios',
            '/admin/resultado-examens',
            '/admin/examens',
            '/admin/examen-variantes',
            '/admin/valor-referencias',
        ];
    }
}
