<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSubmission extends Model
{
    protected $fillable = [
        'exam_id',
        'user_id',
        'answer_content',
        'marks_obtained',
        'feedback',
        'submitted_at',
        'marked_at',
        'marked_by',
        'status',
        'result_approved_at',
        'result_approved_by',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'marked_at' => 'datetime',
        'result_approved_at' => 'datetime',
    ];

    /** Whether the result is finalized (instructor approved). Students see marks only when true. */
    public function isResultFinalized(): bool
    {
        return $this->result_approved_at !== null;
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marked_by');
    }

    public function resultApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'result_approved_by');
    }

    public function submissionAnswers(): HasMany
    {
        return $this->hasMany(ExamSubmissionAnswer::class);
    }
}
