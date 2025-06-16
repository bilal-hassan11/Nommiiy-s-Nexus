<?php

namespace App\Services\Plan;
use App\Repositories\Plan\PlanRepository;

class PlanService
{

    protected $planRepository;

     /**
     * PlanService constructor.
     *
     * @param PlanRepository $planRepository
     */

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }


    public function getAllPlan(array $filters , int $perpage = 10)
    {
        return $this->planRepository->getAllWithPagination($filters , $perpage);
    }



}
