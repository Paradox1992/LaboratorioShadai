<?php

namespace Tests\Feature;

use App\Http\Middleware\EnsureRegisteredDevice;
use App\Models\DeviceAccessToken;
use App\Models\RegisteredDevice;
use App\Models\User;
use App\Security\DeviceJwtManager;
use App\UserRole;
use Firebase\JWT\JWT;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DeviceAccessTokenTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/_tests/device-protected', fn () => response('ok'))
            ->middleware(EnsureRegisteredDevice::class);
    }

    protected function tearDown(): void
    {
        JWT::$timestamp = null;

        parent::tearDown();
    }

    public function test_registered_device_receives_an_encrypted_jwt_cookie(): void
    {
        $device = $this->createDeviceWithRegistrationToken('registration-token');

        $response = $this
            ->withHeader('User-Agent', 'PHPUnit')
            ->get(route('devices.register', 'registration-token'));

        $response
            ->assertRedirect('/admin/login')
            ->assertCookie(config('shadai.device_cookie'))
            ->assertCookie(config('shadai.device_fingerprint_cookie'));

        $this->assertDatabaseHas('tokens_acceso_dispositivo', [
            'dispositivo_registrado_id' => $device->id,
        ]);

        $device->refresh();

        $this->assertNull($device->registro_token_hash);
        $this->assertNotNull($device->fingerprint_hash);
    }

    public function test_middleware_allows_a_matching_unexpired_device_token(): void
    {
        ['token' => $encryptedToken] = $this->createDeviceToken();

        $response = $this
            ->withUnencryptedCookie(config('shadai.device_cookie'), $encryptedToken)
            ->withHeader('User-Agent', 'PHPUnit')
            ->get('/_tests/device-protected');

        $response->assertOk();

        $this->assertNotNull(DeviceAccessToken::query()->first()->last_used_at);
    }

    public function test_middleware_redirects_expired_tokens_to_login(): void
    {
        ['token' => $encryptedToken] = $this->createDeviceToken();

        JWT::$timestamp = now()->addHours(4)->getTimestamp();

        $this
            ->withUnencryptedCookie(config('shadai.device_cookie'), $encryptedToken)
            ->withHeader('User-Agent', 'PHPUnit')
            ->get('/_tests/device-protected')
            ->assertRedirect('/admin/login');
    }

    public function test_registered_fingerprint_can_issue_a_new_token_after_access_token_expires(): void
    {
        ['device' => $device] = $this->createDeviceToken();
        $request = Request::create('/admin/login', 'GET', [], [], [], [
            'HTTP_USER_AGENT' => 'PHPUnit',
        ]);

        $resolvedDevice = app(DeviceJwtManager::class)->deviceFromFingerprint('testing-device', $request);
        $newEncryptedToken = app(DeviceJwtManager::class)->issueEncryptedToken($resolvedDevice, $request);

        $this->assertTrue($device->is($resolvedDevice));
        $this->assertNotSame('', $newEncryptedToken);
        $this->assertSame(2, DeviceAccessToken::query()->count());
    }

    public function test_middleware_rejects_tokens_that_do_not_match_the_device_table(): void
    {
        ['token' => $encryptedToken] = $this->createDeviceToken();

        DeviceAccessToken::query()->delete();

        $this
            ->withUnencryptedCookie(config('shadai.device_cookie'), $encryptedToken)
            ->withHeader('User-Agent', 'PHPUnit')
            ->get('/_tests/device-protected')
            ->assertRedirect('/admin/login');
    }

    /**
     * @return array{device: RegisteredDevice, token: string}
     */
    private function createDeviceToken(): array
    {
        $device = $this->createRegisteredDevice();
        $request = Request::create('/_tests/device-protected', 'GET', [], [], [], [
            'HTTP_USER_AGENT' => 'PHPUnit',
        ]);
        $encryptedToken = app(DeviceJwtManager::class)->issueEncryptedToken($device, $request);

        return [
            'device' => $device,
            'token' => $encryptedToken,
        ];
    }

    private function createDeviceWithRegistrationToken(string $token): RegisteredDevice
    {
        $user = $this->createUser();

        return RegisteredDevice::create([
            'usuario_id' => $user->id,
            'nombre' => 'Equipo de prueba',
            'registro_token_hash' => hash('sha256', $token),
            'estado' => true,
        ]);
    }

    private function createRegisteredDevice(): RegisteredDevice
    {
        $device = $this->createDeviceWithRegistrationToken('token');

        $device->forceFill([
            'fingerprint_hash' => hash('sha256', 'testing-device'),
            'registro_token_hash' => null,
            'ip_registro' => '127.0.0.1',
            'user_agent_registro' => 'PHPUnit',
            'registrado_at' => now(),
            'ultimo_acceso_at' => now(),
        ])->save();

        return $device;
    }

    private function createUser(): User
    {
        return User::create([
            'nombre' => 'Recepcion',
            'usuario' => fake()->unique()->userName(),
            'correo' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'rol' => UserRole::User->value,
            'estado' => true,
        ]);
    }
}
