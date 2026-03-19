<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CareerApplication extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'message',
        'resume_path',
    ];

    /**
     * Resume file URL for download (storage link).
     */
    public function getResumeUrlAttribute(): ?string
    {
        if (! $this->resume_path || ! Storage::disk('public')->exists($this->resume_path)) {
            return null;
        }
        return asset('storage/' . $this->resume_path);
    }
}
