<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $fillable = [
        'course_id',
        'batch_id',
        'instructor_id',
        'title',
        'description',
        'total_marks',
        'passing_marks',
        'duration_minutes',
        'due_date',
        'start_datetime',
        'status',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'start_datetime' => 'datetime',
    ];

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_COMPLETED = 'completed';

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class)->orderBy('sort_order');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(ExamSubmission::class);
    }

    /** Total marks from questions (for MCQ); falls back to exam.total_marks if no questions. */
    public function getTotalMarksFromQuestionsAttribute(): int
    {
        $sum = $this->questions()->sum('marks');
        return $sum > 0 ? (int) $sum : (int) $this->total_marks;
    }

    public function isMcq(): bool
    {
        return $this->questions()->exists();
    }
}
