<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BiometricAttendance extends Model
{
    protected $table = 'biometric_attendance';

    protected $fillable = [
        'user_id',
        'date',
        'check_in_time',
        'check_out_time',
        'status',
        'device_id',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];

    public const STATUS_PRESENT = 'Present';
    public const STATUS_LATE = 'Late';
    public const STATUS_INVALID = 'Invalid';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
