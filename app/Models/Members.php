<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'currency', 'country_code', 'mobile_number', 'full_name', 'username',
        'password', 'force_password_change', 'bank', 'account_number', 'account_name',
        'bank_branch', 'referral_code', 'affiliate_login'
    ];
}
?>
