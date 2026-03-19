<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gatekeeper for online students: if no enrollment has access_expiry_date >= today, redirect to pay-wall.
 * Does not run for SuperAdmin or non-Student roles.
 */
class EnsureStudentAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user) {
            return $next($request);
        }

        if ($user->role?->name === 'SuperAdmin') {
            return $next($request);
        }

        if ($user->role?->name !== 'Student') {
            return $next($request);
        }

        $routeName = $request->route()?->getName();
        if (in_array($routeName, [
            'student.payment-required',
            'student.fee-status',
            'student.payment-info',
        ], true)) {
            return $next($request);
        }

        $hasAccess = $user->enrollments()
            ->where('enrollment_status', 'active')
            ->where(function ($q) {
                $q->where('manual_access', true)
                    ->orWhere(function ($q2) {
                        $q2->whereNotNull('access_expiry_date')
                            ->whereDate('access_expiry_date', '>=', now()->toDateString());
                    });
            })
            ->exists();

        if ($hasAccess) {
            return $next($request);
        }

        return redirect()->route('student.payment-required');
    }
}
