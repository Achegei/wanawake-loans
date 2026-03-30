<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'amount',              // requested loan amount
        'principal',           // principal
        'interest',            // interest amount
        'total_due',           // principal + interest
        'balance_remaining',
        'interest_rate',
        'term_days',
        'due_date',
        'status',              // pending / active / paid / overdue
        'disbursed_at',
        'repayments_done',
        'transaction_id',
    ];

    protected $casts = [
        'disbursed_at' => 'datetime',
        'due_date' => 'datetime',
        'balance_remaining' => 'decimal:2',
        'amount' => 'decimal:2',
        'principal' => 'decimal:2',
        'interest' => 'decimal:2',
        'total_due' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'repayments_done' => 'integer',
        'term_days' => 'integer',
    ];

    // ----------------------
    // Relationships
    // ----------------------
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ----------------------
    // Computed / helper fields
    // ----------------------

    // Principal = stored principal
    public function getPrincipalAttribute($value)
    {
        return $value ?? $this->amount;
    }

    // Interest amount
    public function getInterestAmountAttribute()
    {
        return round($this->interest ?? ($this->principal * ($this->interest_rate / 100)), 2);
    }

    // Total due
    public function getTotalDueAttribute($value)
    {
        return $value ?? round($this->principal + $this->interestAmount, 2);
    }

    // Days left until due
    public function getDaysLeftAttribute()
    {
        return $this->due_date ? $this->due_date->diffInDays(now(), false) : null;
    }

    // Is overdue
    public function isOverdue(): bool
    {
        return $this->due_date && now()->greaterThan($this->due_date) && $this->balance_remaining > 0;
    }

    // Overdue days
    public function getOverdueDaysAttribute()
    {
        if ($this->isOverdue()) {
            return round($this->due_date->diffInDays(now(), false));
        }
        return 0;
    }

    // Mark loan as paid
    public function markAsPaid()
    {
        $this->update([
            'balance_remaining' => 0,
            'status' => 'paid',
            'repayments_done' => $this->repayments_done + 1,
        ]);
    }
}