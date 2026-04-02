<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // for login
use Illuminate\Notifications\Notifiable;

class SalesAgent extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'phone', 
        'email', 
        'id_number', 
        'code', 
        'password'
    ];

    protected $hidden = ['password'];

    // Relation to access codes
    public function accessCodes()
    {
        return $this->hasMany(AgentAccessCode::class);
    }

    // Permanent code generation
    public static function generatePermanentCode()
    {
        do {
            $code = strtoupper(substr(sha1(time() . rand()), 0, 6));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    // Temporary dynamic code generation (for agent dashboard)
    public function generateAccessCode($minutes = 5)
    {
        $code = strtoupper(substr(sha1(time() . rand()), 0, 6));
        return $this->accessCodes()->create([
            'code' => $code,
            'expires_at' => now()->addMinutes($minutes),
        ]);
    }
}