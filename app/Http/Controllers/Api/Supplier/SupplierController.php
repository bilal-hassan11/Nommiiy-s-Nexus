<?php

namespace App\Http\Controllers\Api\Supplier;

use Illuminate\Http\Request;


use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Supplier\SupplierService;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Imports\ImportExcelDataRequest;
use App\Http\Requests\Supplier\CreateSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierStatusRequest;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }


      // Method to download the sample Excel file
      public function downloadSampleExcel()
      {
          $fileName = 'sample_supplier_import.xlsx';
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
          $response = $this->supplierService->importExcelData($request);
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

            // Get paginated and filtered supplier data
            $suppliers = $this->supplierService->getAllSuppliers($filters, $perPage);

            return response()->json($suppliers,  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving suppliers.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }


    public function store(CreateSupplierRequest $request)
    {
        try {
            $userId = Auth::id();
            $data = $request->validated();
            $data['user_id'] = $userId;
            $supplier = $this->supplierService->createSupplier($data);
            return response()->json([
                'message' => 'Supplier created successfully.',
                'data' => $supplier
            ], ApiResponseCodeEnum::CREATED->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the supplier.',
                'error' => $e->getMessage()
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $supplier = $this->supplierService->findSupplierById($id);

            if (!$supplier) {
                return response()->json([
                    'message' => 'Supplier not found.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'data' => $supplier,
                'message' => 'Supplier retrieved successfully.'
            ],  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the supplier.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function update(UpdateSupplierRequest $request, int $id): JsonResponse
    {
        try {
            $updated = $this->supplierService->updateSupplier($id, $request->validated());

            if (!$updated) {
                return response()->json([
                    'message' => 'Supplier not found or update failed.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'message' => 'Supplier updated successfully.'
            ], ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the supplier.',
                'error' => $e->getMessage()
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }



    public function updateStatus(UpdateSupplierStatusRequest $request, int $id): JsonResponse
    {

        try {
            $updated = $this->supplierService->updateSupplierStatus($id, $request->validated());

            if (!$updated) {
                return response()->json([
                    'message' => 'Supplier not found or status update failed.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'message' => 'Supplier status updated successfully.'
            ],  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the supplier status.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }


    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->supplierService->deleteSupplier($id);

            if (!$deleted) {
                return response()->json([
                    'message' => 'Supplier not found or deletion failed.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'message' => 'Supplier deleted successfully.'
            ],  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the supplier.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }


    public function batchDeleteByIds(Request $request): JsonResponse
    {
        try {

            $supplierIds = $request->input('ids');
            if (is_string($supplierIds)) {
                $supplierIds = json_decode(trim($supplierIds), true);
            }

            if (empty($supplierIds) || !is_array($supplierIds)) {
                return response()->json(['message' => 'No suppliers selected for deletion'],  ApiResponseCodeEnum::BAD_REQUEST->value);
            }
            $this->supplierService->batchDeleteSuppliers($supplierIds);

            return response()->json(['message' => 'Suppliers deleted successfully'],  ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }
}
