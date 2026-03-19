<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiometricPunchFailure extends Model
{
    protected $table = 'biometric_punch_failures';

    protected $fillable = [
        'machine_user_id',
        'device_id',
        'scan_time',
        'type',
        'failure_reason',
        'raw_payload',
        'ip_address',
    ];

    protected $casts = [
        'scan_time' => 'datetime',
    ];

    public const REASON_UNKNOWN_USER = 'unknown_user';
    public const REASON_VALIDATION_ERROR = 'validation_error';
    public const REASON_DEVICE_NOT_ALLOWED = 'device_not_allowed';

    public static function logFailure(array $payload, string $reason, ?string $ip = null): self
    {
        return self::create([
            'machine_user_id' => $payload['machine_user_id'] ?? null,
            'device_id' => $payload['device_id'] ?? null,
            'scan_time' => $payload['scan_time'] ?? null,
            'type' => $payload['type'] ?? null,
            'failure_reason' => $reason,
            'raw_payload' => json_encode($payload),
            'ip_address' => $ip,
        ]);
    }
}
