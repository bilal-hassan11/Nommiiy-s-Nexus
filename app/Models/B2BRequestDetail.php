<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class B2BRequestDetail extends Model
{
    public function b2bRequest()
    {
        return $this->belongsTo(B2BRequest::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
