<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_no',
        'user_id',
        'enrollment_id',
        'amount',
        'fee_type',
        'discount_amount',
        'amount_paid',
        'due_date',
        'billing_month',
        'status',
        'description',
        'proof_image_path',
        'created_by',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_VERIFICATION_PENDING = 'verification_pending';
    public const STATUS_PARTIAL = 'partial';
    public const STATUS_PAID = 'paid';
    public const STATUS_OVERDUE = 'overdue';

    protected $casts = [
        'amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'due_date' => 'date',
        'billing_month' => 'date',
    ];

    /** Whether this invoice is a monthly fee voucher (has a billing month). */
    public function isMonthlyVoucher(): bool
    {
        return $this->billing_month !== null && $this->enrollment_id !== null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** Amount due after discount (balance before payments). */
    public function getAmountAfterDiscountAttribute(): float
    {
        return (float) max(0, $this->amount - ($this->discount_amount ?? 0));
    }

    /** Remaining balance to pay (after discount and payments). */
    public function getBalanceAttribute(): float
    {
        return (float) max(0, $this->amount_after_discount - $this->amount_paid);
    }
}
