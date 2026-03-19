<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BiometricLog;
use App\Models\BiometricPunchFailure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Receives ZKTeco uFace / iClock "cdata" push (ATTLOG).
 * Device push URL format: https://your-lms.com/api/biometric/zkteco?api_token=TOKEN
 * Optional: &SN=DEVICE_SERIAL to send device_id.
 * Body: tab-separated lines per record: PIN, DateTime, Status, VerifyType, ...
 * Responds with "OK" so the device accepts the push.
 */
class ZkTecoPushController extends Controller
{
    /** ZKTeco VerifyType → LMS type (BiometricLog::TYPE_*) */
    private const VERIFY_TYPE_MAP = [
        1 => BiometricLog::TYPE_FINGERPRINT,  // Password
        2 => BiometricLog::TYPE_FINGERPRINT,
        3 => BiometricLog::TYPE_CARD,
        4 => BiometricLog::TYPE_CARD,         // NFC
        15 => BiometricLog::TYPE_FACE,
    ];

    public function __invoke(Request $request): Response
    {
        $deviceId = $request->query('SN') ? (string) $request->query('SN') : null;
        $body = $request->getContent();
        $lines = $body ? array_filter(explode("\n", trim($body))) : [];
        $processed = 0;
        $errors = 0;

        foreach ($lines as $line) {
            $fields = explode("\t", trim($line));
            if (count($fields) < 2) {
                continue;
            }
            $pin = trim((string) $fields[0]);
            $dateTime = trim((string) $fields[1]);
            $verifyType = isset($fields[3]) ? (int) $fields[3] : 2;

            if ($pin === '' || $dateTime === '') {
                continue;
            }

            $scanTime = $this->parseScanTime($dateTime);
            if (! $scanTime) {
                $this->logFailureSafely(
                    ['machine_user_id' => $pin, 'device_id' => $deviceId, 'scan_time' => $dateTime, 'type' => $this->mapVerifyType($verifyType)],
                    BiometricPunchFailure::REASON_VALIDATION_ERROR,
                    $request->ip()
                );
                $errors++;
                continue;
            }

            $userId = $this->resolveUserId($pin);
            if ($userId === null) {
                $this->logFailureSafely(
                    ['machine_user_id' => $pin, 'device_id' => $deviceId, 'scan_time' => $scanTime->toDateTimeString(), 'type' => $this->mapVerifyType($verifyType)],
                    BiometricPunchFailure::REASON_UNKNOWN_USER,
                    $request->ip()
                );
                $errors++;
                continue;
            }

            if ($this->createLogSafely($userId, $pin, $deviceId, $scanTime, $verifyType)) {
                $processed++;
            }
        }

        return response('OK', 200, ['Content-Type' => 'text/plain']);
    }

    private function parseScanTime(string $value): ?Carbon
    {
        $formats = ['Y-m-d H:i:s', 'Y-m-d H:i', 'd/m/Y H:i:s', 'd/m/Y H:i', 'YmdHis'];
        foreach ($formats as $format) {
            try {
                $parsed = Carbon::createFromFormat($format, trim($value));
                if ($parsed && ! $parsed->isFuture()) {
                    return $parsed;
                }
            } catch (\Throwable $e) {
                continue;
            }
        }
        try {
            $parsed = Carbon::parse($value);
            return $parsed->isFuture() ? null : $parsed;
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function mapVerifyType(int $code): string
    {
        return self::VERIFY_TYPE_MAP[$code] ?? BiometricLog::TYPE_FINGERPRINT;
    }

    private function resolveUserId(string $machineUserId): ?int
    {
        $normalized = trim($machineUserId);
        $user = User::whereHas('userDetail', fn ($q) => $q->where('biometric_id', $normalized))->first();

        return $user?->id;
    }

    /**
     * Log a failed punch. Catches DB exceptions so the device still receives "OK" and the site does not white-screen.
     */
    private function logFailureSafely(array $payload, string $reason, ?string $ip): void
    {
        try {
            BiometricPunchFailure::logFailure($payload, $reason, $ip);
        } catch (\Throwable $e) {
            Log::warning('ZKTeco push: failed to log punch failure', ['reason' => $reason, 'exception' => $e->getMessage()]);
        }
    }

    /**
     * Create one biometric_log row. Returns true if created; false on DB error (logged).
     */
    private function createLogSafely(int $userId, string $pin, ?string $deviceId, Carbon $scanTime, int $verifyType): bool
    {
        try {
            BiometricLog::create([
                'user_id' => $userId,
                'machine_user_id' => $pin,
                'device_id' => $deviceId,
                'scan_time' => $scanTime,
                'type' => $this->mapVerifyType($verifyType),
            ]);
            return true;
        } catch (\Throwable $e) {
            Log::error('ZKTeco push: failed to create biometric log', ['user_id' => $userId, 'pin' => $pin, 'exception' => $e->getMessage()]);
            return false;
        }
    }
}
