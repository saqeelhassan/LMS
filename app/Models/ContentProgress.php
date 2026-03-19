<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentProgress extends Model
{
    protected $table = 'content_progress';

    protected $fillable = [
        'user_id',
        'course_content_id',
        'last_position_seconds',
        'last_watched_at',
        'completed',
    ];

    protected $casts = [
        'last_watched_at' => 'datetime',
        'completed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function courseContent(): BelongsTo
    {
        return $this->belongsTo(CourseContent::class);
    }
}
