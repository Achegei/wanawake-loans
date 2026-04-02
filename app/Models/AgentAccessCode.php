<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentAccessCode extends Model
{
    use HasFactory;

    protected $fillable = ['sales_agent_id', 'code', 'expires_at', 'used'];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    public function salesAgent()
    {
        return $this->belongsTo(SalesAgent::class);
    }
}