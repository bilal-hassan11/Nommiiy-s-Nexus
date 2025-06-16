<?php

namespace App\Traits;

trait FilterableTrait
{
    public function scopeFilter($query, $filters)
    {
        foreach ($filters as $key => $value) {
            if (method_exists($this, 'scope' . ucfirst($key))) {
                $query->{'scope' . ucfirst($key)}($value);
            } elseif (in_array($key, $this->fillable)) {
                $query->where($key, $value);
            }
        }

        return $query;
    }
}