<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'admin.permission' => \App\Http\Middleware\EnsureAdminPermission::class,
            'student.access' => \App\Http\Middleware\EnsureStudentAccess::class,
            'install.guard' => \App\Http\Middleware\PreventInstallWhenInstalled::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\EnsureAppInstalled::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 403 && $request->expectsJson() === false) {
                return response()->view('errors.403', ['exception' => $e], 403);
            }
            // Session/CSRF expired — send user to a fresh form page
            if ($e->getStatusCode() === 419 && $request->expectsJson() === false) {
                $message = 'Your session expired. Please try again.';
                if ($request->is('sign-up/student')) {
                    return redirect()->route('auth.sign-up.student')->with('error', $message);
                }
                if ($request->is('sign-up/staff')) {
                    return redirect()->route('auth.sign-up.staff')->with('error', $message);
                }
                if ($request->is('super-admin/users*')) {
                    return redirect()->route('super-admin.dashboard')->with('error', $message);
                }
                if ($request->is('sign-in') || $request->is('login')) {
                    return redirect()->route('login')->with('error', $message);
                }
                if ($request->is('forgot-password') || $request->is('password/reset')) {
                    return redirect()->route('password.request')->with('error', $message);
                }
                return redirect()->back()->with('error', $message);
            }
        });
    })->create();
