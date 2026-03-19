<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * If the application is already installed (lock file exists), do not allow access to the installer.
 */
class PreventInstallWhenInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! EnsureAppInstalled::installed()) {
            return $next($request);
        }

        return redirect()->route('login')->with('info', 'Application is already installed.');
    }
}
