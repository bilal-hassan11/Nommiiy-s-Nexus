<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Customer\CustomerService;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Requests\Imports\ImportExcelDataRequest;
use App\Http\Requests\Customer\UpdateCustomerStatusRequest;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }




    public function import(ImportExcelDataRequest $request)
    {
        $response = $this->customerService->importExcelData($request);
        return response()->json($response, $response['success'] ? ApiResponseCodeEnum::CREATED->value : ApiResponseCodeEnum::SERVER_ERROR->value);
            }


      // Method to download the sample Excel file
      public function downloadSampleExcel()
      {
          $fileName = 'sample_customer_import.xlsx';
          $filePath = public_path('excel_format_samples/' . $fileName); // Path to the file in the 'excel_format_samples' folder

          // Check if the file exists
          if (!file_exists($filePath)) {
              return response()->json(['message' => 'Sample file not found.'], 404);
          }

          // Prepare the headers for the response
          return response()->download($filePath, $fileName);
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

            // Get paginated and filtered Customer data
            $customers = $this->customerService->getAllCustomers($filters, $perPage);


            return response()->json($customers,  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving Customers.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }


    public function store(CreateCustomerRequest $request)
    {

        try {
            $userId = Auth::id();
            $data = $request->validated();
            $data['user_id'] = $userId;
            $customer = $this->customerService->createCustomer($data);
            return response()->json([
                'message' => 'Customer created successfully.',
                'data' => $customer
            ], ApiResponseCodeEnum::CREATED->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the Customer.',
                'error' => $e->getMessage()
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $customer = $this->customerService->findCustomerById($id);

            if (!$customer) {
                return response()->json([
                    'message' => 'Customer not found.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'data' => $customer,
                'message' => 'Customer retrieved successfully.'
            ],  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the Customer.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function update(UpdateCustomerRequest $request, int $id): JsonResponse
    {
        try {
            $updated = $this->customerService->updateCustomer($id, $request->validated());

            if (!$updated) {
                return response()->json([
                    'message' => 'Customer not found or update failed.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'message' => 'Customer updated successfully.'
            ], ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the Customer.',
                'error' => $e->getMessage()
            ], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function updateStatus(UpdateCustomerStatusRequest $request, int $id): JsonResponse
    {

        try {
            $updated = $this->customerService->updateCustomerStatus($id, $request->validated());

            if (!$updated) {
                return response()->json([
                    'message' => 'Customer not found.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'message' => 'Customer status updated successfully.'
            ],  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the Customer status.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->customerService->deleteCustomer($id);

            if (!$deleted) {
                return response()->json([
                    'message' => 'Customer not found or deletion failed.'
                ],  ApiResponseCodeEnum::NOT_FOUND->value);
            }

            return response()->json([
                'message' => 'Customer deleted successfully.'
            ],  ApiResponseCodeEnum::OK->value);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the Customer.',
                'error' => $e->getMessage()
            ],  ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }

    public function batchDeleteByIds(Request $request)
    {

        $ids = $request->query('ids');

        if (empty($ids) || !is_array($ids) || empty($ids[0])) {
            return response()->json(['message' => 'Invalid input. Please provide Customer IDs.'], ApiResponseCodeEnum::BAD_REQUEST->value);
        }

        $decodedIds = json_decode($ids[0], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['message' => 'Invalid ID format.'], ApiResponseCodeEnum::BAD_REQUEST->value);
        }

        try {
            $this->customerService->batchDeleteCustomers($decodedIds);

            return response()->json([
                'message' => 'Customer deleted successfully',
            ], ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(
                ['message' => $th->getMessage()],
                ApiResponseCodeEnum::NOT_FOUND->value
            );
        }
    }

}
