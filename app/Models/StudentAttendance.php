<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAttendance extends Model
{
    protected $table = 'student_attendance';

    protected $fillable = [
        'student_id',
        'batch_id',
        'date',
        'status',
        'mode',
        'marked_by',
        'login_time',
    ];

    protected $casts = [
        'date' => 'date',
        'login_time' => 'datetime',
    ];

    /** Academic attendance status */
    public const STATUS_PRESENT = 'Present';
    public const STATUS_ABSENT = 'Absent';
    public const STATUS_LATE = 'Late';
    public const STATUS_LEAVE = 'Leave';

    /** Session mode (Hybrid) */
    public const MODE_PHYSICAL = 'Physical';
    public const MODE_ONLINE = 'Online';

    public static function statuses(): array
    {
        return [
            self::STATUS_PRESENT,
            self::STATUS_ABSENT,
            self::STATUS_LATE,
            self::STATUS_LEAVE,
        ];
    }

    public static function modes(): array
    {
        return [
            self::MODE_PHYSICAL,
            self::MODE_ONLINE,
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function markedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marked_by');
    }
}
