<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $fillable = ['permission_id', 'role_id'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
