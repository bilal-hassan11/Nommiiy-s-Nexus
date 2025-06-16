<?php

namespace App\Traits;

trait SearchableTrait
{
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            foreach ($this->searchable as $column) {
                $q->orWhere($column, 'like', "%{$term}%");
            }
        });
    }
}