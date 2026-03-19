<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'batch_id',
        'payment_method_id',
        'payment_status',
        'fees_collected',
        'fees_due',
        'monthly_fee',
        'course_fee_total',
        'arrears',
        'admission_fee',
        'examination_fee',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'enrollment_status',
        'rejection_note',
        'is_eligible_for_reapplication',
        'completed_at',
        'access_expiry_date',
        'manual_access',
    ];

    protected $casts = [
        'fees_collected' => 'decimal:2',
        'fees_due' => 'decimal:2',
        'monthly_fee' => 'decimal:2',
        'course_fee_total' => 'decimal:2',
        'arrears' => 'decimal:2',
        'admission_fee' => 'decimal:2',
        'examination_fee' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'completed_at' => 'datetime',
        'access_expiry_date' => 'date',
        'is_eligible_for_reapplication' => 'boolean',
        'manual_access' => 'boolean',
    ];

    /**
     * Whether this enrollment can be re-applied for (e.g. after rejection).
     * Edit logic here if you want to restrict re-application in certain cases.
     */
    public function isEligibleForReapplication(): bool
    {
        return ($this->enrollment_status === 'rejected') && ($this->is_eligible_for_reapplication ?? true);
    }

    public const DISCOUNT_NONE = 'None';
    public const DISCOUNT_PERCENTAGE = 'Percentage';
    public const DISCOUNT_FIXED = 'Fixed';

    /** Compute discount amount for a given base amount (from enrollment's permanent scholarship). */
    public function computeDiscountAmount(float $baseAmount): float
    {
        if (($this->discount_type ?? '') === self::DISCOUNT_PERCENTAGE && $this->discount_value !== null) {
            return round($baseAmount * (float) $this->discount_value / 100, 2);
        }
        if (($this->discount_type ?? '') === self::DISCOUNT_FIXED && $this->discount_value !== null) {
            return min((float) $this->discount_value, $baseAmount);
        }
        return 0;
    }

    /** Whether the student has access today (for online gatekeeper). Manual access = free enrollment by super admin. */
    public function hasAccessToday(): bool
    {
        if ($this->manual_access) {
            return true;
        }

        if (! $this->access_expiry_date) {
            return false;
        }

        return now()->toDateString() <= $this->access_expiry_date->format('Y-m-d');
    }

    /**
     * Get the user that owns the enrollment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that owns the enrollment.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the batch for the enrollment.
     */
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Get the payment method for the enrollment.
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    /**
     * Get the invoices for this enrollment.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
