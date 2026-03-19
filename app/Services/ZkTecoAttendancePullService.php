<?php

namespace App\Services;

use App\Models\BiometricLog;
use App\Models\BiometricPunchFailure;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Jmrashed\Zkteco\Lib\ZKTeco;

/**
 * Pulls attendance logs from ZKTeco uFace 800 (or compatible device) via IP:4370,
 * maps device UID/UserID to LMS user_id via user_details.biometric_id,
 * and inserts into biometric_logs with duplicate prevention (same user_id + device_id + scan_time = skip).
 */
class ZkTecoAttendancePullService
{
    public function __construct(
        protected ?string $ip = null,
        protected ?int $port = null,
        protected ?string $deviceId = null
    ) {
        $this->ip = $ip ?? config('zkteco.ip');
        $this->port = $port ?? config('zkteco.port');
        $this->deviceId = $deviceId ?? config('zkteco.device_id');
    }

    /**
     * Pull attendance from device and persist new logs. Returns summary.
     */
    public function pull(): array
    {
        $summary = ['pulled' => 0, 'inserted' => 0, 'skipped_duplicate' => 0, 'unknown_user' => 0, 'error' => null];

        if (empty($this->ip)) {
            $summary['error'] = 'ZKTeco IP not configured. Set ZKTECO_IP in .env.';

            return $summary;
        }

        $zk = new ZKTeco($this->ip, $this->port);

        if (! $zk->connect()) {
            $summary['error'] = "Could not connect to device at {$this->ip}:{$this->port}. Check network and port 4370.";
            Log::warning('ZKTeco pull failed: connection failed', ['ip' => $this->ip, 'port' => $this->port]);

            return $summary;
        }

        try {
            $zk->disableDevice();
            $raw = $zk->getAttendance();
            $zk->enableDevice();
            $zk->disconnect();
        } catch (\Throwable $e) {
            $summary['error'] = $e->getMessage();
            Log::error('ZKTeco pull error', ['ip' => $this->ip, 'exception' => $e->getMessage()]);

            return $summary;
        }

        if (! is_array($raw)) {
            $raw = [];
        }

        $summary['pulled'] = count($raw);
        $deviceId = $this->deviceId ?: ('zkteco-' . preg_replace('/[^a-zA-Z0-9_.-]/', '', $this->ip));

        foreach ($raw as $record) {
            $machineUserId = $this->machineUserIdFromRecord($record);
            $scanTime = $this->parseScanTime($record['timestamp'] ?? null);
            if (! $scanTime) {
                continue;
            }

            $userId = $this->resolveUserId($machineUserId);
            if ($userId === null) {
                $this->logFailureSafely(
                    ['machine_user_id' => $machineUserId, 'device_id' => $deviceId, 'scan_time' => $scanTime->toDateTimeString(), 'type' => $this->mapType($record['type'] ?? 0)],
                    BiometricPunchFailure::REASON_UNKNOWN_USER,
                    null
                );
                $summary['unknown_user']++;
                continue;
            }

            $exists = BiometricLog::where('user_id', $userId)
                ->where('device_id', $deviceId)
                ->where('scan_time', $scanTime->toDateTimeString())
                ->exists();

            if ($exists) {
                $summary['skipped_duplicate']++;
                continue;
            }

            if ($this->createBiometricLogSafely($userId, $machineUserId, $deviceId, $scanTime, $record)) {
                $summary['inserted']++;
            }
        }

        return $summary;
    }

    /**
     * Device record has 'uid' (int) and 'id' (badge string). Map to string for biometric_id lookup.
     */
    private function machineUserIdFromRecord(array $record): string
    {
        $id = trim((string) ($record['id'] ?? ''));
        if ($id !== '') {
            return $id;
        }

        return (string) ($record['uid'] ?? '');
    }

    private function parseScanTime(mixed $timestamp): ?Carbon
    {
        if ($timestamp === null || $timestamp === '') {
            return null;
        }
        try {
            $t = Carbon::parse($timestamp);
            return $t->isFuture() ? null : $t;
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function mapType(int $code): string
    {
        return match ($code) {
            2 => BiometricLog::TYPE_CARD,
            15 => BiometricLog::TYPE_FACE,
            default => BiometricLog::TYPE_FINGERPRINT,
        };
    }

    private function resolveUserId(string $machineUserId): ?int
    {
        $normalized = trim($machineUserId);
        if ($normalized === '') {
            return null;
        }
        $user = User::whereHas('userDetail', fn ($q) => $q->where('biometric_id', $normalized))->first();

        return $user?->id;
    }

    /**
     * Log a failed punch to biometric_punch_failures. Catches DB exceptions so one failure does not white-screen.
     */
    private function logFailureSafely(array $payload, string $reason, ?string $ip): void
    {
        try {
            BiometricPunchFailure::logFailure($payload, $reason, $ip);
        } catch (\Throwable $e) {
            Log::warning('ZKTeco: failed to log punch failure', ['reason' => $reason, 'exception' => $e->getMessage()]);
        }
    }

    /**
     * Create one biometric_log row. Returns true if created; false on duplicate or DB error (logged).
     */
    private function createBiometricLogSafely(int $userId, string $machineUserId, string $deviceId, Carbon $scanTime, array $record): bool
    {
        try {
            BiometricLog::create([
                'user_id' => $userId,
                'machine_user_id' => $machineUserId,
                'device_id' => $deviceId,
                'scan_time' => $scanTime,
                'type' => $this->mapType($record['type'] ?? 0),
            ]);
            return true;
        } catch (\Throwable $e) {
            Log::error('ZKTeco: failed to create biometric log', [
                'user_id' => $userId,
                'machine_user_id' => $machineUserId,
                'exception' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
