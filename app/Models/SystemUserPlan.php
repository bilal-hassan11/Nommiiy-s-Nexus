<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemUserPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'billing_cycle',
        'amount',
        'start_date',
        'expiry_date',
        'is_expired',
        'cancel_date',
        'system_user_id',
        'user_id',
    ];

    public function plan()
    {
        return $this->belongsTo(Plans::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
