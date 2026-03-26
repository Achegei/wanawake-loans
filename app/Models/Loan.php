<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'employment_status',
        'income_range',
        'loan_amount',
        'pay_day',
        'current_limit',
        'repayments_done',
    ];

    /**
     * Each loan belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A loan can have multiple next-of-kin contacts
     */
    public function nextOfKin()
    {
        return $this->hasMany(LoanNextOfKin::class);
    }
}