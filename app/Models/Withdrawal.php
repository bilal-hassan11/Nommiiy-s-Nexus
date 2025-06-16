<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'merchant',
        'username',
        'currency',
        'payment_channel', // Changed from paymentType to snake_case
        'created_at',     // Assuming this maps to your Start Date
        'member_group',
        'withdraw_id',
        'status',
        'completed_at',   // Assuming this maps to your End Date
        'risk',
        'merchant_bank',  // Changed from merchantBank to snake_case
        'time_zone',
        'player_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'currency' => 'array',
        'created_at' => 'datetime',
        'completed_at' => 'datetime',
        'withdraw_id' => 'integer',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'created_at',
        'completed_at',
    ];
}
