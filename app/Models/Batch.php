<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batch extends Model
{
    /** Government program codes when batch is government-funded. */
    public const GOVERNMENT_PITP = 'PITP';
    public const GOVERNMENT_NAVTTC = 'NAVTTC';
    public const GOVERNMENT_BBSHRRDA = 'BBSHRRDA';

    public static function governmentProgramOptions(): array
    {
        return [
            self::GOVERNMENT_PITP => 'PITP',
            self::GOVERNMENT_NAVTTC => 'NAVTTC',
            self::GOVERNMENT_BBSHRRDA => 'BBSHRRDA',
        ];
    }

    protected $fillable = [
        'course_id',
        'name',
        'instructor_id',
        'branch_id',
        'start_date',
        'end_date',
        'schedule_note',
        'monthly_fee',
        'is_active',
        'is_government_funded',
        'government_program',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'monthly_fee' => 'decimal:2',
        'is_active' => 'boolean',
        'is_government_funded' => 'boolean',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function timetableSlots(): HasMany
    {
        return $this->hasMany(TimetableSlot::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Academic attendance records for this batch (per student per date).
     */
    public function studentAttendances(): HasMany
    {
        return $this->hasMany(StudentAttendance::class, 'batch_id');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public static function dayNames(): array
    {
        return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    }

    /**
     * Human-readable schedule for display (timetable slots or schedule_note).
     */
    public function getScheduleDisplayAttribute(): string
    {
        if ($this->schedule_note) {
            return $this->schedule_note;
        }
        $slots = $this->timetableSlots()->orderBy('day_of_week')->orderBy('start_time')->get();
        if ($slots->isEmpty()) {
            return '—';
        }
        $days = self::dayNames();
        $parts = [];
        foreach ($slots as $slot) {
            $day = $days[$slot->day_of_week] ?? ('Day ' . $slot->day_of_week);
            $start = $slot->start_time instanceof \Carbon\Carbon ? $slot->start_time->format('g A') : \Carbon\Carbon::parse($slot->start_time)->format('g A');
            $end = $slot->end_time instanceof \Carbon\Carbon ? $slot->end_time->format('g A') : \Carbon\Carbon::parse($slot->end_time)->format('g A');
            $parts[] = $day . ' (' . $start . '-' . $end . ')';
        }
        return implode(', ', $parts);
    }
}
