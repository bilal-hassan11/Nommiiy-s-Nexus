<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryRestriction extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant',
        'country',
        'name',
        'whitelist',
        'status',
        'remark',
    ];

    // Optional: Cast `whitelist` to a boolean
    protected $casts = [
        'whitelist' => 'boolean',
    ];
}