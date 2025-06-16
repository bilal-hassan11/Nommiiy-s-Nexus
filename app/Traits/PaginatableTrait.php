<?php

namespace App\Traits;

trait PaginatableTrait
{
    public function scopePaginateWith($query, $perPage = 15)
    {
        return $query->paginate($perPage);
    }
}