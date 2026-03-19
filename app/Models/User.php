<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use CanResetPassword, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'role_id',
        'branch_id',
        'is_active',
        'program_category',
    ];

    /** Program classification for government-funded offline programs. */
    public const PROGRAM_REGULAR = 'Regular';
    public const PROGRAM_PITP = 'PITP';
    public const PROGRAM_NAVTTC = 'NAVTTC';
    public const PROGRAM_BBSHRRDA = 'BBSHRRDA';

    public static function programCategoryOptions(): array
    {
        return [
            self::PROGRAM_REGULAR => 'Regular',
            self::PROGRAM_PITP => 'PITP',
            self::PROGRAM_NAVTTC => 'NAVTTC',
            self::PROGRAM_BBSHRRDA => 'BBSHRRDA',
        ];
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Profile picture URL (from user_details.profile_picture), or null if not set.
     * Uses asset() so the image loads correctly on the current domain/port.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        $path = $this->userDetail?->profile_picture;

        if (! $path) {
            return null;
        }

        if (! Storage::disk('public')->exists($path)) {
            return null;
        }

        return asset('storage/' . $path);
    }

    /**
     * Get the display name (from user details or fallback to email).
     */
    public function getNameAttribute(): string
    {
        $detail = $this->userDetail;

        if (! $detail) {
            return $this->email;
        }

        $fullName = trim($detail->first_name . ' ' . $detail->last_name);

        return $fullName !== '' ? $fullName : $this->email;
    }

    /**
     * Get the branch for the user.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user's details.
     */
    public function userDetail(): HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    /**
     * Get the enrollments for the user.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Courses taught by this user (when they are the instructor).
     */
    public function instructorCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    /**
     * Academic attendance records when this user is a student.
     */
    public function studentAttendances(): HasMany
    {
        return $this->hasMany(StudentAttendance::class, 'student_id');
    }

    /**
     * Payroll attendance records when this user is an instructor.
     */
    public function instructorAttendances(): HasMany
    {
        return $this->hasMany(InstructorAttendance::class, 'instructor_id');
    }

    /**
     * Batches taught by this user (when they are the instructor).
     */
    public function instructorBatches(): HasMany
    {
        return $this->hasMany(Batch::class, 'instructor_id');
    }

    /**
     * Admin-only: permissions assigned by Super Admin (only for role Admin).
     */
    public function adminPermissions(): HasMany
    {
        return $this->hasMany(AdminPermission::class);
    }

    /**
     * Whether this user can perform the given admin permission.
     * Super Admin has all; Staff has none of these; Admin has only assigned ones.
     */
    public function hasAdminPermission(string $permission): bool
    {
        $roleName = $this->role?->name;

        if ($roleName === 'SuperAdmin') {
            return true;
        }

        if ($roleName !== 'Admin') {
            return false;
        }

        $list = Cache::remember(
            "user.{$this->id}.admin_permissions",
            now()->addMinutes(5),
            fn () => $this->adminPermissions()->pluck('permission')->all()
        );

        return in_array($permission, $list, true);
    }
}
