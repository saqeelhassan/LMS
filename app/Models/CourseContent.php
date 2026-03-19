<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseContent extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'type',
        'url',
        'file_path',
        'file_name',
        'sort_order',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function progressRecords(): HasMany
    {
        return $this->hasMany(ContentProgress::class);
    }
}
