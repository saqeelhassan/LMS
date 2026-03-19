<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\Http\Foundation\Response;

/**
 * Secures the biometric punch API. Only requests with a valid token are allowed.
 * Supports optional device allowlist via BIOMETRIC_DEVICE_IDS (comma-separated).
 *
 * Token can be sent as: Bearer token, X-Biometric-Token header, or api_token input.
 * Set BIOMETRIC_API_TOKEN in .env (use a long random string, e.g. php artisan tinker + Str::random(64)).
 */
class ValidateBiometricToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken()
            ?? $request->header('X-Biometric-Token')
            ?? $request->input('api_token');

        $expected = config('services.biometric.token');

        if (! $expected || $token !== $expected) {
            return response()->json(['success' => false, 'message' => 'Invalid or missing API token.'], 401);
        }

        $deviceIds = config('services.biometric.device_ids', []);
        if (! empty($deviceIds)) {
            $deviceId = trim((string) ($request->input('device_id') ?? $request->header('X-Device-ID') ?? $request->query('SN') ?? ''));
            if ($deviceId === '' || ! in_array($deviceId, $deviceIds, true)) {
                return response()->json(['success' => false, 'message' => 'Device not authorized.'], 403);
            }
        }

        return $next($request);
    }
}
