<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\NextOfKin;

#[Fillable([
    'name',
    'email',
    'phone',
    'id_number',
    'employment_status',
    'monthly_income',
    'wallet_id',
    'selfie_path',
    'id_photo_path',
    'password'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'monthly_income' => 'decimal:2',
            'is_admin' => 'boolean',
        ];
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
    public function nextOfKin()
    {
        return $this->hasMany(NextOfKin::class);
    }

    public function activeLoan()
    {
        return $this->hasOne(Loan::class)
                    ->where('status', 'active')
                    ->latestOfMany();
    }

    public function loan()
    {
        // Returns the latest loan as a relationship instance
        return $this->hasOne(Loan::class)->latestOfMany();
    }

    // Calculate dynamic loan limit
    public function getLoanLimitAttribute()
    {
        $base = 500; // starting limit
        $level = 0;

        $paidLoans = $this->loans()
                          ->where('status', 'paid')
                          ->orderBy('disbursed_at')
                          ->get();

        $count = 0;

        foreach ($paidLoans as $loan) {
            if ($loan->principal == $base + ($level * 500)) {
                $count++;
            }

            if ($count >= 3) {
                $level++;
                $count = 0; // reset for next level
            }
        }

        return $base + ($level * 500);
    }

    // Count repaid loans at current level
    public function repaidAtCurrentLevel()
    {
        $currentLimit = $this->loan_limit;
        return $this->loans()
                    ->where('status', 'paid')
                    ->where('principal', $currentLimit)
                    ->count();
    }
}