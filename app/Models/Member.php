<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant',
        'player_id',
        'username',
        'bank_account_number',
        'member_name',
        'member_group',
        'contact_number',
        'referral',
        'currency',
        'kyc_status',
        'status',
        'register_from',
        'register_to',
        'affiliate_code',
        'affiliate_username',
        'risk',
        'vip_level',
        'last_login_from',
        'last_login_to',
        'time_zone',
        'referral_site',
        'email',
        'member_tag',
        'referral_link',
    ];

    protected $casts = [
        'register_from' => 'date',
        'register_to' => 'date',
        'last_login_from' => 'date',
        'last_login_to' => 'date',

        'currency' => 'array',
    ];
}
