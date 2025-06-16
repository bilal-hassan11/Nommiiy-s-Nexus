<?php

namespace App\Http\Controllers\Api\SystemUserPlan;


use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Services\SystemUserPlans\SystemUserPlansService;
use App\Http\Requests\SystemUserPlans\SystemUserPlanRequest;

class SystemUserPlanController extends Controller
{

    protected $systemUserPlanService;

    public function __construct(SystemUserPlansService $systemUserPlanService)
    {
        $this->systemUserPlanService = $systemUserPlanService;
    }


    public function index(Request $request): JsonResponse
    {
        $response =  $this->systemUserPlanService->getAllSystemUserPlans($request);
        if ($response['success']) {
            return sendResponse(false,  ApiResponseCodeEnum::OK->value, $response['data'], 'User Plan Retreived successfully.');
        }
        return sendResponse(true,  ApiResponseCodeEnum::SERVER_ERROR->value, $response['errors'], 'An error occurred while reteivering  the User Plans.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(SystemUserPlanRequest $request)
    {
        $data = $request->validated();
        $response =  $this->systemUserPlanService->createsystemUserPlan($data);
        if ($response['success']) {
            return sendResponse(false,  ApiResponseCodeEnum::OK->value, $response['data'], 'User Plan created successfully.');
        }
        return sendResponse(true,  ApiResponseCodeEnum::SERVER_ERROR->value, $response['errors'], 'An error occurred while creating the User Plan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $response =  $this->systemUserPlanService->deletesystemUserPlan($id);
        if ($response['success']) {
            return sendResponse(false,  ApiResponseCodeEnum::OK->value, $response['data'], 'User Plan Deleted successfully.');
        }
        return sendResponse(true,  ApiResponseCodeEnum::SERVER_ERROR->value, $response['errors'], 'An error occurred while creating the User Plan.');
    }

    public function cancel(int $id): JsonResponse
    {
        $response = $this->systemUserPlanService->cancelSystemUserPlan($id);
        if ($response['success']) {
            return sendResponse(false,  ApiResponseCodeEnum::OK->value, $response['data'], 'User Plan Canceled successfully.');
        }
        return sendResponse(true,  ApiResponseCodeEnum::SERVER_ERROR->value, $response['errors'], 'An error occurred while creating the User Plan.');
    }
}
