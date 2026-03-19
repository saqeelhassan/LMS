<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the enrollments for the payment method.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'payment_method_id');
    }
}
