<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class Loan extends Model
{
    // ✅ Mass assignable fields
    protected $fillable = [
        'user_id',
        'loan_amount',         // original loan amount
        'balance_remaining',   // current unpaid balance
        'interest_rate',       // e.g., 10
        'term_days',           // loan duration in days
        'due_date',            // date loan is due
        'status',              // active / paid / overdue
        'disbursed_at',        // timestamp when loan is issued
        'repayments_done',     // number of repayments completed
        'current_limit',       // optional: user-specific loan limit
    ];

    // ✅ Cast fields for proper type handling
    protected $casts = [
        'disbursed_at' => 'datetime',
        'due_date' => 'datetime',
        'balance_remaining' => 'decimal:2',
        'loan_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'repayments_done' => 'integer',
        'term_days' => 'integer',
    ];

    // ✅ Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nextOfKin()
    {
        return $this->hasMany(LoanNextOfKin::class);
    }

    // ✅ Computed property: days left until due
    public function daysLeft(): int
    {
        if (!$this->due_date) {
            return 0;
        }

        $now = Carbon::now();
        return max(0, $this->due_date->diffInDays($now, false));
    }

    // ✅ Computed property: is loan overdue?
    public function isOverdue(): bool
    {
        return $this->due_date && Carbon::now()->greaterThan($this->due_date) && $this->balance_remaining > 0;
    }

    // ✅ Attribute accessor: format balance nicely
    protected function formattedBalance(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->balance_remaining, 2)
        );
    }

    // ✅ Mark loan as fully paid
    public function markAsPaid()
    {
        $this->update([
            'balance_remaining' => 0,
            'status' => 'paid',
            'repayments_done' => $this->repayments_done + 1,
        ]);
    }
}