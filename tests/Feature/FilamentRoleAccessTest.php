<?php

namespace Tests\Feature;

use App\Filament\Resources\AuditoriaEventos\AuditoriaEventoResource;
use App\Filament\Resources\Examens\ExamenResource;
use App\Filament\Resources\OrdenLaboratorios\OrdenLaboratorioResource;
use App\Filament\Resources\Pacientes\PacienteResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use App\UserRole;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class FilamentRoleAccessTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/_tests/operator-role', fn () => response('ok'))
            ->middleware(['auth', 'role:OPERADOR,SOPORTE']);
    }

    public function test_user_role_can_only_access_patients(): void
    {
        $this->actingAs($this->userWithRole(UserRole::User));

        $this->assertTrue(PacienteResource::canAccess());
        $this->assertFalse(OrdenLaboratorioResource::canAccess());
        $this->assertFalse(ExamenResource::canAccess());
        $this->assertFalse(UserResource::canAccess());
    }

    public function test_operador_role_can_access_everything_except_administration(): void
    {
        $this->actingAs($this->userWithRole(UserRole::Operador));

        $this->assertTrue(PacienteResource::canAccess());
        $this->assertTrue(OrdenLaboratorioResource::canAccess());
        $this->assertTrue(ExamenResource::canAccess());
        $this->assertFalse(UserResource::canAccess());
        $this->assertFalse(AuditoriaEventoResource::canAccess());
    }

    public function test_soporte_role_can_access_everything(): void
    {
        $this->actingAs($this->userWithRole(UserRole::Soporte));

        $this->assertTrue(PacienteResource::canAccess());
        $this->assertTrue(OrdenLaboratorioResource::canAccess());
        $this->assertTrue(ExamenResource::canAccess());
        $this->assertTrue(UserResource::canAccess());
        $this->assertTrue(AuditoriaEventoResource::canAccess());
    }

    public function test_role_middleware_blocks_direct_routes_for_user_role(): void
    {
        $this->actingAs($this->userWithRole(UserRole::User))
            ->get('/_tests/operator-role')
            ->assertForbidden();

        $this->actingAs($this->userWithRole(UserRole::Operador))
            ->get('/_tests/operator-role')
            ->assertOk();
    }

    private function userWithRole(UserRole $role): User
    {
        return User::factory()->create([
            'rol' => $role->value,
        ]);
    }
}
