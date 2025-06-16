<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\TaxDiscountStatus;

class Tax extends BaseModel
{

    protected $fillable = [
        'name',
        'tax_value',
        'tax_type',
        'tax_nature',
        'system_user_id',
        'user_id',

    ];

    protected $casts = [
        'tax_type' => TaxDiscountStatus::class,
        'tax_nature' => TaxDiscountStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
