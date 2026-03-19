<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamQuestion extends Model
{
    protected $fillable = [
        'exam_id',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'marks',
        'sort_order',
    ];

    protected $casts = [
        'marks' => 'integer',
        'sort_order' => 'integer',
    ];

    public const OPTIONS = ['a', 'b', 'c', 'd'];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function submissionAnswers(): HasMany
    {
        return $this->hasMany(ExamSubmissionAnswer::class);
    }

    public function isCorrect(string $selected): bool
    {
        return strtolower($selected) === strtolower($this->correct_option);
    }
}
