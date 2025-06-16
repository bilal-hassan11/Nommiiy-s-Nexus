<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SystemIdScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $systemUserId = get_system_user_id() !== false ? get_system_user_id() : 1;
         $builder->where('system_user_id', $systemUserId);
    }
}
