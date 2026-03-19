<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceDeduction extends Model
{
    protected $table = 'attendance_deductions';

    protected $fillable = [
        'enrollment_id',
        'period_start',
        'period_end',
        'absences_count',
        'late_count',
        'fine_per_absence',
        'total_amount',
        'applied_at',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'fine_per_absence' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'applied_at' => 'datetime',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
