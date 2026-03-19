<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'course_interest',
        'status',
        'notes',
        'branch_id',
        'assigned_to',
        'converted_to_user_id',
        'converted_at',
    ];

    protected $casts = [
        'converted_at' => 'datetime',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function convertedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'converted_to_user_id');
    }
}
