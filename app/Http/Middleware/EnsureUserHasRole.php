<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request. Expects parameter: role name(s) comma-separated (e.g. "admin" or "admin,staff").
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $userRoleName = $request->user()->role?->name;

        if (! $userRoleName) {
            abort(403, 'Your account has no role assigned.');
        }

        $allowed = array_map('strtolower', $roles);
        $userRoleLower = strtolower($userRoleName);

        if (! in_array($userRoleLower, $allowed, true)) {
            abort(403, 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}
