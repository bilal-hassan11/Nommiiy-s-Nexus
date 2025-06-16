<?php

namespace App\Models;

use App\Models\BaseModel;

class Role extends BaseModel
{

    protected $fillable = ['name', 'user_id', 'system_user_id'];
    protected $hidden = ['created_at', 'updated_at'];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_roles');
    }


    public function users()
    {
        return $this->hasMany(User::class);
    }




}
