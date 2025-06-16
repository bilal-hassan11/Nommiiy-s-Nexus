<?php

namespace App\Models;

use App\Models\BaseModel;

class ProductCategory extends BaseModel
{
    protected $fillable = [
        'name',
        'system_user_id',
        'user_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];


    public function systemUser()
    {
        return $this->belongsTo(User::class, 'system_user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
