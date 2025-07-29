<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralInfoSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency',
        'about_us_enabled',
        'faq_enabled',
        'terms_enabled',
        'privacy_policy_enabled',
        'responsible_gaming_enabled',
        'disconnect_policy_enabled',
    ];

    protected $casts = [
        'about_us_enabled' => 'boolean',
        'faq_enabled' => 'boolean',
        'terms_enabled' => 'boolean',
        'privacy_policy_enabled' => 'boolean',
        'responsible_gaming_enabled' => 'boolean',
        'disconnect_policy_enabled' => 'boolean',
    ];
}