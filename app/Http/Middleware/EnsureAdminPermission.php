<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPermission
{
    /**
     * Allow if SuperAdmin, or Staff (full admin panel access for now), or Admin with the given permission.
     * Usage: ->middleware('admin.permission:courses.manage')
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();
        $roleName = $user->role?->name;

        if ($roleName === 'SuperAdmin') {
            return $next($request);
        }

        if ($roleName === 'Staff') {
            return $next($request);
        }

        if ($roleName === 'Admin' && $user->hasAdminPermission($permission)) {
            return $next($request);
        }

        abort(403, 'You do not have permission to access this.');
    }
}
