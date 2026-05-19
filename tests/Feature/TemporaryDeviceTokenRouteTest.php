<?php

namespace Tests\Feature;

use App\Models\RegisteredDevice;
use App\Models\User;
use App\UserRole;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class TemporaryDeviceTokenRouteTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_it_displays_the_temporary_device_token_form(): void
    {
        $this->get(route('temporary-device-token.create'))
            ->assertOk()
            ->assertSee('Token de dispositivo')
            ->assertSee('Usuario SOPORTE')
            ->assertSee('Generar enlace');
    }

    public function test_support_user_can_generate_a_registration_link(): void
    {
        User::factory()->create([
            'usuario' => 'soporte',
            'rol' => UserRole::Soporte->value,
        ]);
        $targetUser = User::factory()->create([
            'usuario' => 'recepcion',
            'rol' => UserRole::User->value,
        ]);

        $response = $this->post(route('temporary-device-token.store'), [
            'soporte_usuario' => 'soporte',
            'soporte_password' => 'password',
            'nombre' => 'Mi equipo',
            'usuario' => 'recepcion',
        ]);

        $device = RegisteredDevice::query()->first();

        $response
            ->assertSessionHas('registration_url')
            ->assertRedirect(route('temporary-device-token.create'));

        $this->assertNotNull($device);
        $this->assertSame($targetUser->id, $device->usuario_id);
        $this->assertSame('Mi equipo', $device->nombre);
        $this->assertNotNull($device->registro_token_hash);
    }

    public function test_it_rejects_invalid_support_credentials(): void
    {
        User::factory()->create([
            'usuario' => 'soporte',
            'rol' => UserRole::Soporte->value,
        ]);

        $this->post(route('temporary-device-token.store'), [
            'soporte_usuario' => 'soporte',
            'soporte_password' => 'incorrecta',
            'nombre' => 'Mi equipo',
        ])->assertSessionHasErrors('soporte_usuario');

        $this->assertSame(0, RegisteredDevice::query()->count());
    }

    public function test_it_rejects_non_support_users(): void
    {
        User::factory()->create([
            'usuario' => 'operador',
            'rol' => UserRole::Operador->value,
        ]);

        $this->post(route('temporary-device-token.store'), [
            'soporte_usuario' => 'operador',
            'soporte_password' => 'password',
            'nombre' => 'Mi equipo',
        ])->assertSessionHasErrors('soporte_usuario');

        $this->assertSame(0, RegisteredDevice::query()->count());
    }
}
