<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BiometricLog extends Model
{
    protected $table = 'biometric_logs';

    protected $fillable = [
        'user_id',
        'machine_user_id',
        'device_id',
        'scan_time',
        'type',
    ];

    protected $casts = [
        'scan_time' => 'datetime',
    ];

    public const TYPE_FINGERPRINT = 'Fingerprint';
    public const TYPE_FACE = 'Face';
    public const TYPE_CARD = 'Card';

    public static function types(): array
    {
        return [self::TYPE_FINGERPRINT, self::TYPE_FACE, self::TYPE_CARD];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
