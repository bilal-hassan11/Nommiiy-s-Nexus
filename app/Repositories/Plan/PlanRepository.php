<?php

namespace App\Repositories\Plan;

use App\Models\Plans;


class PlanRepository
{

    protected $model;

    public function __construct(Plans $model)
    {
        $this->model = $model;
    }


    public function getAllWithPagination(array $filters, int $perpage = 10)
    {
        $query = $this->model->query();
        if (isset($filters['name'])) {
            $query->where(
                'name',
                'like',
                '%' . $filters['name'] . '%'
            );
        }
        if (isset($filters['amount'])) {
            $query->where('amount', $filters['amount']);
        }
        if (isset($filters['description'])) {
            $query->where('description', $filters['description']);
        }
        return $query->paginate($perpage);
    }
}
