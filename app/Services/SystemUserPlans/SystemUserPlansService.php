<?php

namespace App\Services\SystemUserPlans;

use App\Enums\PlanStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SystemUserPlans\SystemUserPlansRepository;

class SystemUserPlansService
{

    protected $systemUserPlans;

    /**
     * TaxService constructor.
     *
     * @param SystemUserPlansRepository $taxRepository
     */

    public function __construct(SystemUserPlansRepository $systemUserPlans)
    {
        $this->systemUserPlans = $systemUserPlans;
    }



    public function createsystemUserPlan(array $data)
    {
        $data['billing_cycle'] = $data['billing_cycle'] ?? PlanStatus::YEARLY->value;

        // Auto-fill user_id with the logged-in user's ID
        $data['user_id'] = Auth::id();

        $data['start_date'] = Carbon::now();

        if ($data['billing_cycle'] === PlanStatus::MONTHLY->value) {
            $data['expiry_date'] = $data['start_date']->copy()->addMonth();
        } elseif ($data['billing_cycle'] === PlanStatus::YEARLY->value) {
            $data['expiry_date'] = $data['start_date']->copy()->addYear();
        }

        $data['is_expired'] = false;

        try {
            $userPlan = $this->systemUserPlans->create($data);
            return [
                'success' => true,
                'data' => $userPlan,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => $e->getMessage(),
                'data' => null,
                'message' => 'An error occurred while creating the system user plan.',
            ];
        }
    }


    public function getAllSystemUserPlans(Request $request): array
    {
        try {
            $filters = [
                'system_user_id' => $request->input('system_user_id'),
            ];

            $perPage = $request->input('per_page', 10);

            $plans = $this->systemUserPlans->getAllWithPagination($filters, $perPage);

            return [
                'success' => true,
                'data' => $plans,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => $e->getMessage(),
            ];
        }
    }


    public function deletesystemUserPlan(int $id): array
    {
        try {
            $deleted = $this->systemUserPlans->delete($id);

            if (!$deleted) {
                return [
                    'success' => false,
                    'errors' => 'System User Plan not found.',
                    'data' => null,
                ];
            }

            return [
                'success' => true,
                'errors' => null,
                'data' => null,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => $e->getMessage(),
                'data' => null,
            ];
        }
    }



    public function cancelSystemUserPlan(int $id): array
    {
        try {
            $cancelled = $this->systemUserPlans->cancel($id);

            if (!$cancelled) {
                return [
                    'success' => false,
                    'errors' => 'System User Plan not found or cancellation failed.',
                    'data' => null
                ];
            }

            return [
                'success' => true,
                'errors' => null,
                'data' => null,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
