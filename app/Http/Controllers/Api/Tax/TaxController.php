<?php

namespace App\Http\Controllers\Api\Tax;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tax\TaxCreateRequest;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Tax\TaxUpdateRequest;
use App\Repositories\Tax\TaxRepository;

class TaxController extends Controller
{
    protected $taxService;
    protected $taxRepository;

    public function __construct(TaxRepository $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            // Get filters from request
            $filters = [
                'name' => $request->input('name'),
                'tax_nature' => $request->input('tax_nature'),
                'tax_type' => $request->input('tax_type'),
            ];

            $allowedPerPageOptions = [10, 20, 50, 100, 500, 1000, 'all'];
            $perPage = $request->input('per_page', 10);

            // Ensure perPage is in the allowed options
            if (!in_array($perPage, $allowedPerPageOptions)) {
                $perPage = 10;
            }

            // Get paginated and filtered Tax data
            $shops = $this->taxRepository->getAllWithPagination($filters, $perPage);

            return response()->json($shops,  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving Taxes.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function store(TaxCreateRequest $request)
    {
        try {
            $data = $request->validated();
            $tax = $this->taxRepository->create($data);
            return response()->json([
                'message' => 'Tax created successfully.',
                'data' => $tax
            ], ApiResponseCodeEnum::CREATED->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "An error occurred while creating the tax",
                'error' => $e->getMessage(),
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $tax = $this->taxRepository->findById($id);

            if (!$tax) {
                return response()->json([
                    'message' => 'Tax not found.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'data' => $tax,
                'message' => 'Tax retrieved successfully.'
            ],  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the Tax.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function update(TaxUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $updated = $this->taxRepository->update($id, $request->validated());

            if (!$updated) {
                return response()->json([
                    'message' => 'Tax not found or update failed.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'message' => 'Tax updated successfully.'
            ], ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the Tax.',
                'error' => $e->getMessage()
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {

        try {

            $this->taxRepository->delete($id);

            return response()->json(['message' => 'Tax deleted successfully'], ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {

            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }



    public function batchDeleteByIds(Request $request)
    {

        $ids = $request->query('ids');

        if (empty($ids) || !is_array($ids) || empty($ids[0])) {
            return response()->json(['message' => 'Invalid input. Please provide user IDs.'], ApiResponseCodeEnum::BAD_REQUEST->value);
        }

        $decodedIds = json_decode($ids[0], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['message' => 'Invalid ID format.'], ApiResponseCodeEnum::BAD_REQUEST->value);
        }

        try {
            $this->taxRepository->batchDelete($decodedIds);

            return response()->json([
                'message' => 'Taxes deleted successfully',
            ], ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(
                ['message' => $th->getMessage()],
                ApiResponseCodeEnum::NOT_FOUND->value
            );
        }
    }
}
