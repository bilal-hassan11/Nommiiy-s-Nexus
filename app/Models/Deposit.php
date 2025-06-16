<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'member',
        'currency',
        'bank_account',
        'amount',
        'date',
        'member_bank',
        'reference_number',
        'receipt_path',
    ];
}
