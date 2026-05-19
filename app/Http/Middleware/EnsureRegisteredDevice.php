<?php

namespace App\Http\Middleware;

use App\Security\DeviceJwtManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRegisteredDevice
{
    public function handle(Request $request, Closure $next): Response
    {
        $encryptedToken = $request->cookie(config('shadai.device_cookie'));

        if (blank($encryptedToken)) {
            if ($this->isLoginRequest($request)) {
                $this->logoutAuthenticatedUser($request);

                return $next($request);
            }

            return $this->redirectToLogin();
        }

        $device = app(DeviceJwtManager::class)->deviceFromEncryptedToken($encryptedToken, $request);

        if (! $device) {
            if ($this->isLoginRequest($request)) {
                $this->logoutAuthenticatedUser($request);

                return $next($request);
            }

            $this->logoutAuthenticatedUser($request);

            return $this->redirectToLogin();
        }

        $device->forceFill(['ultimo_acceso_at' => now()])->save();

        return $next($request);
    }

    private function isLoginRequest(Request $request): bool
    {
        return $request->is('admin/login');
    }

    private function redirectToLogin(): Response
    {
        return redirect('/admin/login');
    }

    private function logoutAuthenticatedUser(Request $request): void
    {
        if (! Auth::check()) {
            return;
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
