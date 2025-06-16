<?php

namespace App\Http\Controllers\Api\Discount;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Discount\DiscountCreateRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Discount\DiscountUpdateRequest;
use App\Repositories\Discount\DiscountRepository;

class DiscountController extends Controller
{
    protected $discountRepository;

    public function __construct(DiscountRepository $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            // Get filters from request
            $filters = [
                'name' => $request->input('name'),
                'discount_type' => $request->input('discount_type'),
            ];

            // Define per-page limit for pagination (default to 10)
            $allowedPerPageOptions = [10, 20, 50, 100, 500, 1000, 'all'];
            $perPage = $request->input('per_page', 10);

            // Ensure perPage is in the allowed options
            if (!in_array($perPage, $allowedPerPageOptions)) {
                $perPage = 10;
            }

            // Get paginated and filtered Discount data
            $discounts = $this->discountRepository->getAllWithPagination($filters, $perPage);

            return response()->json($discounts, ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving Discounts.',
                'error' => $e->getMessage()
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function store(DiscountCreateRequest $request)
    {
        try {
            $data = $request->validated();
            $discount = $this->discountRepository->create($data);
            return response()->json([
                'message' => 'Discount created successfully.',
                'data' => $discount
            ], ApiResponseCodeEnum::CREATED->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "An error occurred while creating the discount",
                'error' => $e->getMessage(),
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $discount = $this->discountRepository->findById($id);

            if (!$discount) {
                return response()->json([
                    'message' => 'Discount not found.'
                ], ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'data' => $discount,
                'message' => 'Discount retrieved successfully.'
            ], ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the Discount.',
                'error' => $e->getMessage()
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function update(DiscountUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $updated = $this->discountRepository->update($id, $request->validated());

            if (!$updated) {
                return response()->json([
                    'message' => 'Discount not found or update failed.'
                ], ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'message' => 'Discount updated successfully.'
            ], ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the Discount.',
                'error' => $e->getMessage()
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->discountRepository->delete($id);
            return response()->json(['message' => 'Discount deleted successfully'], ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function batchDeleteByIds(Request $request)
    {
        $ids = $request->query('ids');

        if (empty($ids) || !is_array($ids) || empty($ids[0])) {
            return response()->json(['message' => 'Invalid input. Please provide discount IDs.'], ApiResponseCodeEnum::BAD_REQUEST->value);
        }

        $decodedIds = json_decode($ids[0], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['message' => 'Invalid ID format.'], ApiResponseCodeEnum::BAD_REQUEST->value);
        }

        try {
            $this->discountRepository->batchDelete($decodedIds);
            return response()->json([
                'message' => 'Discounts deleted successfully',
            ], ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }
}
