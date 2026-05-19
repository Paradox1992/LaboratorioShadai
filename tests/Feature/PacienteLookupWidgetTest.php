<?php

namespace Tests\Feature;

use App\Filament\Widgets\PacienteLookupWidget;
use App\Models\Paciente;
use App\Models\RegisteredDevice;
use App\Models\User;
use App\Security\DeviceJwtManager;
use App\UserRole;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\Request;
use Livewire\Livewire;
use Tests\TestCase;

class PacienteLookupWidgetTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_it_is_available_for_user_and_soporte_roles_only(): void
    {
        foreach ([UserRole::User, UserRole::Soporte] as $role) {
            $this->actingAs(User::factory()->create([
                'rol' => $role->value,
            ]));

            $this->assertTrue(PacienteLookupWidget::canView());

            Livewire::test(PacienteLookupWidget::class)
                ->assertSee('Verificar paciente');
        }

        $this->actingAs(User::factory()->create([
            'rol' => UserRole::Operador->value,
        ]));

        $this->assertFalse(PacienteLookupWidget::canView());
    }

    public function test_it_is_visible_on_the_dashboard(): void
    {
        $user = User::factory()->create([
            'rol' => UserRole::User->value,
        ]);
        $device = RegisteredDevice::create([
            'usuario_id' => $user->id,
            'nombre' => 'Equipo de prueba',
            'fingerprint_hash' => hash('sha256', 'testing-device'),
            'estado' => true,
        ]);
        $deviceToken = app(DeviceJwtManager::class)->issueEncryptedToken($device, Request::create('/admin'));

        $this
            ->actingAs($user)
            ->withCookie(config('shadai.device_cookie'), $deviceToken)
            ->get('/admin')
            ->assertOk()
            ->assertSee('Verificar paciente');
    }

    public function test_it_finds_patients_by_document_or_name(): void
    {
        $this->actingAs(User::factory()->create([
            'rol' => UserRole::User->value,
        ]));

        Paciente::create([
            'docid' => '0801199012345',
            'nombres' => 'Ana',
            'apellidos' => 'Lopez',
            'fecha_nacimiento' => '1990-01-01',
            'sexo' => 'FEMENINO',
            'telefono' => '99998888',
            'estado' => true,
        ]);

        Paciente::create([
            'docid' => '0801198811111',
            'nombres' => 'Carlos',
            'apellidos' => 'Mejia',
            'fecha_nacimiento' => '1988-01-01',
            'sexo' => 'MASCULINO',
            'telefono' => '88887777',
            'estado' => true,
        ]);

        Livewire::test(PacienteLookupWidget::class)
            ->assertDontSee('Ana')
            ->set('tableSearch', '0801199012345')
            ->assertSee('0801199012345')
            ->assertSee('Ana Lopez')
            ->assertDontSee('Carlos Mejia')
            ->set('tableSearch', 'Carlos')
            ->assertSee('Carlos Mejia')
            ->assertDontSee('Ana Lopez');
    }
}
