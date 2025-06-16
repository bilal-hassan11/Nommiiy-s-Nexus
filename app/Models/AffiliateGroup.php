<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateGroup extends Model
{
    protected $fillable = [
        'merchant', 'name', 'currency', 'member_group', 'remark', 'default_status', 'active', 'sequence',
        'no_minimum', 'no_maximum', 'minimum', 'maximum',
        'daily_count', 'no_daily_maximum', 'daily_maximum_count',
        'no_minimum_deposit', 'no_maximum_deposit', 'minimum_deposit', 'maximum_deposit',
        'deposit_wallet', 'commission_wallet', 'minimum_transfer_limit', 'maximum_transfer_limit',
        'daily_maximum_transfer_limit', 'target_multiplier',
    ];

    protected $casts = [
        'active' => 'boolean',
        'no_minimum' => 'boolean',
        'no_maximum' => 'boolean',
        'no_daily_maximum' => 'boolean',
        'no_minimum_deposit' => 'boolean',
        'no_maximum_deposit' => 'boolean',
        'deposit_wallet' => 'boolean',
        'commission_wallet' => 'boolean',
    ];
}
