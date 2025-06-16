<?php

namespace App\Models;

use App\Enums\SupplierStatus;
use App\Models\BaseModel;

class Customer extends BaseModel
{

    protected $fillable = [
        'name',
        'email',
        'address',
        'phone_number',
        'system_user_id',
        'user_id',
        'status',
        'nin_bvn'
    ];

    protected static function booted()
    {
        static::creating(function ($supplier) {
            if (!$supplier->status) {
                $supplier->status = SupplierStatus::ACTIVE;
            }
        });
    }

    // Cast enum as before
    protected $casts = [
        'status' => SupplierStatus::class,
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
