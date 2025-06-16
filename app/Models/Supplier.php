<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\SupplierStatus;

class Supplier extends BaseModel
{
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone_number',
        'system_user_id',
        'user_id',
        'status',
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

    public function systemUser()
    {
        return $this->belongsTo(User::class, 'system_user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
