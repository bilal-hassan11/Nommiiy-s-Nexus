<?php

namespace App\Models;

use App\Models\BaseModel;

class B2BRequest extends BaseModel
{
    public function fromShop()
    {
        return $this->belongsTo(Shop::class, 'from_shop_id');
    }

    public function toShop()
    {
        return $this->belongsTo(Shop::class, 'to_shop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function b2bRequestDetails()
    {
        return $this->hasMany(B2BRequestDetail::class);
    }
}
