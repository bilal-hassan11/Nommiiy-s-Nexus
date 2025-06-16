<?php

namespace App\Models;

use App\Models\BaseModel;

class Comments extends BaseModel
{
    public function requestedToShop()
    {
        return $this->belongsTo(Shop::class, 'requested_to_shop');
    }

    public function requestedFromShop()
    {
        return $this->belongsTo(Shop::class, 'requested_from_shop');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
