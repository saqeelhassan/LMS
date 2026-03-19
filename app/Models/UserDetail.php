<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'biometric_id',
        'first_name',
        'last_name',
        'designation',
        'father_name',
        'cnic',
        'mobile',
        'contact_no',
        'whatsapp',
        'emergency_contact',
        'gender',
        'address',
        'city',
        'state',
        'current_address',
        'last_qualification',
        'domicile_district',
        'profile_picture',
        'cnic_front_path',
        'cnic_back_path',
        'last_degree_path',
        'domicile_prc_path',
    ];

    /**
     * Get the user that owns the details.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
