<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'agent_id',           // ✅ ADD (agent tracking)
        'access_code_id',     // ✅ ADD (code used)
        'amount',
        'principal',
        'interest',
        'total_due',
        'balance_remaining',
        'interest_rate',
        'term_days',
        'due_date',
        'status',             // pending / active / paid / overdue
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Borrower
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Agent who created/handled this loan
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    // Access code used
    public function accessCode()
    {
        return $this->belongsTo(AgentAccessCode::class, 'access_code_id');
    }

    /*
    |--------------------------------------------------------------------------
    | COMPUTED FIELDS
    |--------------------------------------------------------------------------
    */

    // Principal fallback
    public function getPrincipalAttribute($value)
    {
        return $value ?? $this->amount;
    }

    // Interest amount
    public function getInterestAmountAttribute()
    {
        return round(
            $this->interest ?? ($this->principal * ($this->interest_rate / 100)),
            2
        );
    }

    // Total due
    public function getTotalDueAttribute($value)
    {
        return $value ?? round($this->principal + $this->interest_amount, 2);
    }

    // Hours left (VERY IMPORTANT FIX)
    public function getHoursLeftAttribute()
{
    if (!$this->disbursed_at || $this->status === 'paid') {
        return null;
    }

    // Use timezone from app
    $now = now()->setTimezone(config('app.timezone'));
    $due = $this->due_date->copy()->setTimezone(config('app.timezone'));

    // Signed difference
    $hours = $due->diffInHours($now, false);

    // Return 0 if negative (overdue will be handled separately)
    return $hours >= 0 ? $hours : 0;
}

    // Days left
    public function getDaysLeftAttribute()
    {
        if (!$this->disbursed_at || $this->status === 'paid') {
            return null;
        }

        return now()->diffInDays($this->due_date, false);
    }

    // Is overdue
    public function isOverdue(): bool
    {
        if ($this->status === 'paid') {
            return false;
        }

        $now = now()->setTimezone(config('app.timezone'));
        return $now->greaterThan($this->due_date);
    }
    // Overdue days
    public function getOverdueDaysAttribute()
    {
        if ($this->isOverdue()) {
            return abs(now()->diffInDays($this->due_date));
        }

        return 0;
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIONS
    |--------------------------------------------------------------------------
    */

    // Mark as paid
    public function markAsPaid()
    {
        $this->update([
            'balance_remaining' => 0,
            'status' => 'paid',
            'repayments_done' => $this->repayments_done + 1,
        ]);
    }
}