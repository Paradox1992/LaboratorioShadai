<?php

namespace App\Security;

use App\Models\DeviceAccessToken;
use App\Models\RegisteredDevice;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Throwable;

class DeviceJwtManager
{
    public function issueEncryptedToken(RegisteredDevice $device, Request $request): string
    {
        $issuedAt = now();
        $expiresAt = $issuedAt->copy()->addMinutes($this->ttlMinutes());
        $jwtId = (string) Str::uuid();

        $payload = [
            'iss' => config('app.url'),
            'sub' => (string) $device->getKey(),
            'jti' => $jwtId,
            'iat' => $issuedAt->getTimestamp(),
            'nbf' => $issuedAt->getTimestamp(),
            'exp' => $expiresAt->getTimestamp(),
            'device_id' => $device->getKey(),
            'device_hash' => $device->fingerprint_hash,
        ];

        $jwt = JWT::encode($payload, $this->signingKey(), 'HS256');

        DeviceAccessToken::create([
            'dispositivo_registrado_id' => $device->getKey(),
            'jwt_id' => $jwtId,
            'token_hash' => hash('sha256', $jwt),
            'user_agent_hash' => $this->userAgentHash($request),
            'ip_address' => $request->ip(),
            'issued_at' => $issuedAt,
            'expires_at' => $expiresAt,
        ]);

        return Crypt::encryptString($jwt);
    }

    public function deviceFromEncryptedToken(string $encryptedToken, Request $request): ?RegisteredDevice
    {
        try {
            $jwt = Crypt::decryptString($encryptedToken);
            $payload = JWT::decode($jwt, new Key($this->signingKey(), 'HS256'));
        } catch (Throwable) {
            return null;
        }

        return $this->resolveDeviceFromPayload($jwt, $payload, $request);
    }

    public function deviceFromFingerprint(string $fingerprint, Request $request): ?RegisteredDevice
    {
        if (blank($fingerprint)) {
            return null;
        }

        $device = RegisteredDevice::query()
            ->where('fingerprint_hash', hash('sha256', $fingerprint))
            ->where('estado', true)
            ->first();

        if (! $device) {
            return null;
        }

        if (filled($device->user_agent_registro) && ! hash_equals((string) $device->user_agent_registro, (string) $request->userAgent())) {
            return null;
        }

        return $device;
    }

    public function ttlMinutes(): int
    {
        return max(1, (int) config('shadai.device_token_ttl_minutes', 180));
    }

    private function signingKey(): string
    {
        return (string) config('app.key');
    }

    private function resolveDeviceFromPayload(string $jwt, object $payload, Request $request): ?RegisteredDevice
    {
        $deviceId = (int) ($payload->device_id ?? $payload->sub ?? 0);
        $jwtId = (string) ($payload->jti ?? '');
        $deviceHash = (string) ($payload->device_hash ?? '');

        if ($deviceId < 1 || blank($jwtId) || blank($deviceHash)) {
            return null;
        }

        $accessToken = DeviceAccessToken::query()
            ->with('device')
            ->where('dispositivo_registrado_id', $deviceId)
            ->where('jwt_id', $jwtId)
            ->where('token_hash', hash('sha256', $jwt))
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->first();

        if (! $accessToken || ! $accessToken->device || ! $accessToken->device->estado) {
            return null;
        }

        if (! hash_equals((string) $accessToken->device->fingerprint_hash, $deviceHash)) {
            return null;
        }

        $expectedUserAgentHash = (string) $accessToken->user_agent_hash;

        if ($expectedUserAgentHash !== '' && ! hash_equals($expectedUserAgentHash, $this->userAgentHash($request))) {
            return null;
        }

        $accessToken->forceFill(['last_used_at' => now()])->save();

        return $accessToken->device;
    }

    private function userAgentHash(Request $request): string
    {
        return hash('sha256', (string) $request->userAgent());
    }
}
