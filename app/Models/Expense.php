<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = ['type', 'description', 'amount', 'expense_date', 'branch_id', 'recorded_by', 'payee_user_id', 'payee_name'];

    protected $casts = ['expense_date' => 'date', 'amount' => 'decimal:2'];

    public const TYPE_SALARY = 'salary';
    public const TYPE_LAB = 'lab_maintenance';
    public const TYPE_SERVER = 'server';
    public const TYPE_OTHER = 'other';

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payee_user_id');
    }
}
