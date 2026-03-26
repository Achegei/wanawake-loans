<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanNextOfKin extends Model
{
    protected $fillable = ['loan_id', 'name', 'phone', 'relation'];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}