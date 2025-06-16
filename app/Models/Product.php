<?php

namespace App\Models;

use App\Models\BaseModel;

class Product extends BaseModel
{

    // Product model
    protected $fillable = [
        'name',
        'barcode',
        'purchase_price',
        'selling_price',
        'low_alert_qty',
        'category_id',
        'image',
        'description',
        'system_user_id',
        'user_id'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function b2bRequestDetails()
    {
        return $this->hasMany(B2BRequestDetail::class);
    }
}
