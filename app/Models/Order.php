<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'supplier_id',
        'shop_id',
        'payment_method',
        'purchase_date',
        'payment_status',
        'paid_amount',
        'total_amount',
        'order_status',
        'expected_delivery_date',
        'delivery_status',
        'type',
        'notes',
        'system_user_id',
        'user_id',
    ];


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function fromShop()
    {
        return $this->belongsTo(Shop::class, 'from_shop_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
