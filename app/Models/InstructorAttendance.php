<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstructorAttendance extends Model
{
    protected $table = 'instructor_attendance';

    protected $fillable = [
        'instructor_id',
        'date',
        'check_in_time',
        'check_out_time',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];

    /** Payroll attendance status */
    public const STATUS_PRESENT = 'Present';
    public const STATUS_ABSENT = 'Absent';
    public const STATUS_LEAVE = 'Leave';

    public static function statuses(): array
    {
        return [
            self::STATUS_PRESENT,
            self::STATUS_ABSENT,
            self::STATUS_LEAVE,
        ];
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Total worked minutes for the day (for payroll).
     * Returns null if check_in or check_out is missing.
     */
    public function getWorkedMinutesAttribute(): ?int
    {
        if (!$this->check_in_time || !$this->check_out_time) {
            return null;
        }

        return (int) $this->check_in_time->diffInMinutes($this->check_out_time);
    }
}
