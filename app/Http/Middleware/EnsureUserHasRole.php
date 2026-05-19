<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user instanceof User) {
            abort(403);
        }

        $allowedRoles = collect($roles)
            ->map(fn (string $role): ?UserRole => UserRole::fromStoredValue($role))
            ->filter();

        if ($allowedRoles->doesntContain($user->role())) {
            abort(403);
        }

        return $next($request);
    }
}
