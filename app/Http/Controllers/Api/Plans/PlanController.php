<?php

namespace App\Http\Controllers\Api\Plans;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Services\Plan\PlanService;

class PlanController extends Controller
{

    protected $planService;
    public function __construct(PlanService $planService) {
        $this->planService = $planService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Get filters from request
            $filters = [
                'name' => $request->input('name'),
                'amount' => $request->input('amount'),
                'description' => $request->input('description'),
            ];

            // Define per-page limit for pagination (default to 10)
            $perPage = $request->input('per_page', 10);

            // Get paginated and filtered Tax data
            $shops = $this->planService->getAllPlan($filters, $perPage);


            return response()->json($shops,  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving Taxes.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
    public function destroy(string $id)
    {
        //
    }
}
