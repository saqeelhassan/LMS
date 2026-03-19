<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSubmissionAnswer extends Model
{
    protected $fillable = [
        'exam_submission_id',
        'exam_question_id',
        'selected_option',
    ];

    public function examSubmission(): BelongsTo
    {
        return $this->belongsTo(ExamSubmission::class);
    }

    public function examQuestion(): BelongsTo
    {
        return $this->belongsTo(ExamQuestion::class);
    }
}
