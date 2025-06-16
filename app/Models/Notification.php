<?php

namespace App\Models;

use App\Models\BaseModel;

class Notification extends BaseModel
{
    public function systemUser()
    {
        return $this->belongsTo(User::class, 'system_user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
