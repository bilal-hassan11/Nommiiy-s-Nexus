<?php

namespace App\Traits;

trait OrderableTrait
{
    public function scopeOrder($query, $orderBy = 'created_at', $direction = 'desc')
    {

        return $query->orderBy($orderBy, $direction);
    }
}