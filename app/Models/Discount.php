<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\TaxDiscountStatus;

class Discount extends BaseModel
{

    protected $fillable = [
        'name',
        'discount_value',
        'discount_type',
        'system_user_id',
        'user_id',

    ];

    protected $casts = [
        'discount_type' => TaxDiscountStatus::class,
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
