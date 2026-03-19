<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;

    public const PUBLICATION_DRAFT = 'draft';
    public const PUBLICATION_PENDING = 'pending_approval';
    public const PUBLICATION_APPROVED = 'approved';
    public const PUBLICATION_REJECTED = 'rejected';

    protected $fillable = [
        'name',
        'course_mode_id',
        'description',
        'thumbnail',
        'release_date',
        'total_hours',
        'certificate',
        'skills',
        'total_lectures',
        'language',
        'instructor_id',
        'live_class_url',
        'publication_status',
        'submitted_for_approval_at',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
    ];

    protected $casts = [
        'release_date' => 'date',
        'certificate' => 'boolean',
        'submitted_for_approval_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /** Scope: courses that are active (approved) for public display. */
    public function scopeActive($query)
    {
        return $query->where('publication_status', self::PUBLICATION_APPROVED);
    }

    /** Scope: courses visible on website (approved + draft so instructor-created courses show until approved). */
    public function scopeVisibleOnWebsite($query)
    {
        return $query->whereIn('publication_status', [self::PUBLICATION_APPROVED, self::PUBLICATION_DRAFT]);
    }

    public function scopePublishedOnWebsite($query)
    {
        return $query->where('publication_status', self::PUBLICATION_APPROVED);
    }

    public function isPublishedOnWebsite(): bool
    {
        return ($this->publication_status ?? self::PUBLICATION_APPROVED) === self::PUBLICATION_APPROVED;
    }

    /** Whether course is visible on website (approved or draft). */
    public function isVisibleOnWebsite(): bool
    {
        return in_array($this->publication_status ?? self::PUBLICATION_DRAFT, [self::PUBLICATION_APPROVED, self::PUBLICATION_DRAFT], true);
    }

    public function approver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejecter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * Course thumbnail URL (uploaded image or placeholder). Uses asset() so images display on website /courses page.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            return asset('storage/' . $this->thumbnail);
        }
        $num = ($this->id ?? 0) % 12;
        return asset('images/courses/4by3/' . str_pad((string) ($num + 1), 2, '0', STR_PAD_LEFT) . '.jpg');
    }

    /**
     * Get the course mode that owns the course.
     */
    public function courseMode(): BelongsTo
    {
        return $this->belongsTo(CourseMode::class, 'course_mode_id');
    }

    /**
     * Get the instructor (user) that owns the course.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the enrollments for the course.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the exams for the course.
     */
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Get the attendances for the course.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the batches for the course.
     */
    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    /**
     * Get the course contents (videos, PDFs, source code).
     */
    public function contents(): HasMany
    {
        return $this->hasMany(CourseContent::class, 'course_id')->orderBy('sort_order');
    }

    /**
     * Get the assignments for the course.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get the quizzes for the course.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}
