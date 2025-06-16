<?php

namespace App\Http\Controllers\Api\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Shop\ShopService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Shop\ShopCreateRequest;
use App\Http\Requests\Shop\ShopUpdateRequest;
use App\Http\Requests\Shop\ShopStatusUpdateRequest;
use App\Http\Requests\Imports\ImportExcelDataRequest;

class ShopController extends Controller
{
    protected $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

      // Method to download the sample Excel file
      public function downloadSampleExcel()
      {
          $fileName = 'sample_shop_import.xlsx';
          $filePath = public_path('excel_format_samples/' . $fileName); // Path to the file in the 'excel_format_samples' folder

          // Check if the file exists
          if (!file_exists($filePath)) {
              return response()->json(['message' => 'Sample file not found.'], 404);
          }

          // Prepare the headers for the response
          return response()->download($filePath, $fileName);
      }

      public function import(ImportExcelDataRequest $request)
      {
          $response = $this->shopService->importExcelData($request);
          return response()->json($response, $response['success'] ? ApiResponseCodeEnum::CREATED->value : ApiResponseCodeEnum::SERVER_ERROR->value);

              }

    public function index(Request $request): JsonResponse
    {
        try {
            // Get filters from request
            $filters = [
                'name' => $request->input('name'),
                'status' => $request->input('status'),
            ];

            // Define per-page limit for pagination (default to 10)
            $perPage = $request->input('per_page', 10);

            // Get paginated and filtered Shop data
            $shops = $this->shopService->getAllShops($filters, $perPage);


            return response()->json($shops,  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving Shops.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }


    public function store(ShopCreateRequest $request)
    {

        try {
            $userId = Auth::id();
            $data = $request->validated();
            $data['user_id'] = $userId;
            $shop = $this->shopService->createShop($data);
            return response()->json([
                'message' => 'Shop created successfully.',
                'data' => $shop
            ], ApiResponseCodeEnum::CREATED->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the Shop.',
                'error' => $e->getMessage()
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }


    public function show(int $id): JsonResponse
    {
        try {
            $shop = $this->shopService->findShopById($id);

            if (!$shop) {
                return response()->json([
                    'message' => 'Shop not found.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'data' => $shop,
                'message' => 'Shop retrieved successfully.'
            ],  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the Shop.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }


    public function update(ShopUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $updated = $this->shopService->updateShop($id, $request->validated());

            if (!$updated) {
                return response()->json([
                    'message' => 'Shop not found or update failed.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'message' => 'Shop updated successfully.'
            ], ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the Shop.',
                'error' => $e->getMessage()
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }


    public function updateStatus(ShopStatusUpdateRequest $request, int $id): JsonResponse
    {

        try {
            $updated = $this->shopService->updateShopStatus($id, $request->validated());

            if (!$updated) {
                return response()->json([
                    'message' => 'Shop not found.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'message' => 'Shop status updated successfully.'
            ],  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the Shop status.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->shopService->deleteShop($id);

            if (!$deleted) {
                return response()->json([
                    'message' => 'Shop not found or deletion failed.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'message' => 'Shop deleted successfully.'
            ],  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the Shop.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }


    public function batchDeleteByIds(Request $request): JsonResponse
    {
        try {

            $shopIds = $request->input('ids');
            if (is_string($shopIds)) {
                $shopIds = json_decode(trim($shopIds), true);
            }

            if (empty($shopIds) || !is_array($shopIds)) {
                return response()->json(['message' => 'No Shops selected for deletion'],  ApiResponseCodeEnum::BAD_REQUEST->value);
            }
            $this->shopService->batchDeleteShops($shopIds);

            return response()->json(['message' => 'Shops deleted successfully'],  ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }
}
