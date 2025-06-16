<?php

namespace App\Repositories\SystemUserPlans;

use Carbon\Carbon;
use App\Models\SystemUserPlan;


class SystemUserPlansRepository
{

    protected $model;

    public function __construct(SystemUserPlan $model)
    {
        $this->model = $model;
    }




    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getAllWithPagination(array $filters, int $perpage = 10)
    {
        $query = $this->model->query();
        if (isset($filters['system_user_id'])) {
            $query->where('system_user_id', $filters['system_user_id']);
        }

        return $query->paginate($perpage);
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function delete(int $id)
    {
        $plan = $this->findById($id);

        if ($plan) {
            return $plan->delete();
        }

        return false;
    }

    public function cancel(int $id)
    {
        $plan = $this->findById($id);

        if ($plan) {
            $plan->is_expired = true;
            $plan->cancel_date = Carbon::now();
            return $plan->save();
        }

        return false;
    }
}
