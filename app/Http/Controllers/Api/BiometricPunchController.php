<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BiometricPunchRequest;
use App\Models\BiometricLog;
use App\Models\BiometricPunchFailure;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * Receives punch data from biometric devices (ZKTeco/Hikvision).
 * Successful punches (resolved user) → biometric_logs.
 * Failed punches (unknown user, validation) → biometric_punch_failures.
 * Punch logic (check-in/check-out, late, ghost) is applied by BiometricPunchProcessor.
 */
class BiometricPunchController extends Controller
{
    /**
     * Accept a single biometric punch (machine_user_id, scan_time, optional device_id and type).
     * Resolves machine user ID to LMS user via user_details.biometric_id; returns 422 if not found.
     */
    public function __invoke(BiometricPunchRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $lmsUserId = $this->resolveUserId($validated['machine_user_id']);

        if ($lmsUserId === null) {
            $this->logFailureSafely($validated, $request->ip());

            return response()->json([
                'success' => false,
                'message' => 'User not found. Machine ID not mapped in LMS.',
                'machine_user_id' => $validated['machine_user_id'],
            ], 422);
        }

        if (! $this->createLogSafely($lmsUserId, $validated)) {
            return response()->json(['success' => false, 'message' => 'Failed to save punch.'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Punch recorded.',
            'user_id' => $lmsUserId,
        ]);
    }

    /**
     * Resolve device's system ID (e.g. 1005) to LMS user_id.
     * user_details.biometric_id must match the value registered on the device.
     */
    private function resolveUserId(string $machineUserId): ?int
    {
        $normalized = trim($machineUserId);
        $user = User::whereHas('userDetail', fn ($q) => $q->where('biometric_id', $normalized))->first();

        return $user?->id;
    }

    /**
     * Log an unknown-user punch to biometric_punch_failures. Catches DB exceptions to avoid white-screen.
     */
    private function logFailureSafely(array $payload, ?string $ip): void
    {
        try {
            BiometricPunchFailure::logFailure($payload, BiometricPunchFailure::REASON_UNKNOWN_USER, $ip);
        } catch (\Throwable $e) {
            Log::warning('Biometric API: failed to log punch failure', ['exception' => $e->getMessage()]);
        }
    }

    /**
     * Create one biometric_log row. Returns true on success, false on DB error (logged).
     */
    private function createLogSafely(int $userId, array $validated): bool
    {
        try {
            BiometricLog::create([
                'user_id' => $userId,
                'machine_user_id' => $validated['machine_user_id'],
                'device_id' => $validated['device_id'] ?? null,
                'scan_time' => $validated['scan_time'],
                'type' => $validated['type'] ?? BiometricLog::TYPE_FINGERPRINT,
            ]);
            return true;
        } catch (\Throwable $e) {
            Log::error('Biometric API: failed to create log', ['user_id' => $userId, 'exception' => $e->getMessage()]);
            return false;
        }
    }
}
