<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * If the application is not installed (no lock file), redirect to /install.
 * Install routes are excluded via route names so they are not redirected.
 */
class EnsureAppInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (static::installed()) {
            return $next($request);
        }

        if ($request->routeIs('install.*')) {
            return $next($request);
        }

        return redirect()->route('install.show');
    }

    public static function installed(): bool
    {
        return file_exists(storage_path('installed'));
    }
}
