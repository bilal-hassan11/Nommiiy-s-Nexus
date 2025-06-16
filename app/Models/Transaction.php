<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant',
        'username',
        'currency',
        'payment_channel',
        'created_at',
        'member_group',
        'status',
        'payment_method',
        'completed_at',
        'risk',
        'order_id',
        'affiliate_username',
        'time_zone',
        'transaction_id',
        'reference_number',
        'player_id',
    ];
}
