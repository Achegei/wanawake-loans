<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function loan()
{
    return $this->hasOne(Loan::class);
}
}