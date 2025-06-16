<?php

namespace App\Models;

use App\Models\BaseModel;

class Shop extends BaseModel
{
    protected $fillable = [
        'name',
        'location',
        'contact_number',
        'system_user_id',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function fromOrders()
    {
        return $this->hasMany(Order::class, 'from_shop_id');
    }

    public function b2bRequestsFrom()
    {
        return $this->hasMany(B2BRequest::class, 'from_shop_id');
    }

    public function b2bRequestsTo()
    {
        return $this->hasMany(B2BRequest::class, 'to_shop_id');
    }
}
