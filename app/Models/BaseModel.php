<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\SystemIdScope;

class BaseModel extends Model
{
    protected $fillable = ['system_user_id', 'user_id']; // Include user_id if necessary

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SystemIdScope);

         static::creating(function ($model) {
            $model->system_user_id = get_system_user_id() !== false ? get_system_user_id() : 1;
            $model->user_id = get_login_user_id();

        });

        static::updating(function ($model) {
            $model->system_user_id = get_system_user_id() !== false ? get_system_user_id() : 1;
        });
    }
}
