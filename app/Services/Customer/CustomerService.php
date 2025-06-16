<?php

namespace App\Services\Customer;

use Complex\Exception;

use Illuminate\Http\Request;
use App\Enums\SupplierStatus;
use App\Imports\CustomerImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Services\Import\ImportExcelDataService;
use App\Repositories\Customer\CustomerRepository;

class CustomerService  extends ImportExcelDataService
{
    protected $customerRepository;

    /**
     * CustomerService constructor.
     *
     * @param CustomerRepository $CustomerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Get a list of all customers.
     *
     * @return mixed
     */
    public function getAllCustomers(array $filters, int $perPage = 10)
    {
        return $this->customerRepository->getAllWithPagination($filters, $perPage);
    }

    /**
     * Create a new customers.
     *
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function createCustomer(array $data)
    {
        // Set default status if not provided
        $data['status'] = $data['status'] ?? SupplierStatus::ACTIVE->value;
        return $this->customerRepository->create($data);
    }


    public function importExcelData(Request $request): array
    {
        $file = $request->file('file'); // Get the uploaded file

        try {

            DB::beginTransaction();
            $importResult = $this->import(new CustomerImport(), $file); // Pass the import class

            if (!$importResult['success']) {
                DB::rollback();
                return $importResult; // Return if the import failed
            }


            DB::commit();

            return [
                'success' => true,
                    'message' => 'Import completed successfully.',
                    'count' => $importResult['count'],

            ];
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollback();
            return [
                'success' => false,
                'message' => 'An error occurred while importing.',
                'error' => $e->getMessage(),
            ];
        }
    }



    /**
     * Find a customers by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function findCustomerById(int $id)
    {
        return $this->customerRepository->findById($id);
    }

    /**
     * Update an existing customers.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function updateCustomer(int $id, array $data)
    {
        return $this->customerRepository->update($id, $data);
    }

    public function deleteCustomer(int $id)
    {
        return $this->customerRepository->delete($id);
    }


    public function updateCustomerStatus(int $id, array $data)
    {
        return $this->customerRepository->updateStatus($id, $data['status']);
    }


    // Batch delete customers and their contacts
    public function batchDeleteCustomers(array $customerIds)
    {
        // Call the repository to handle the batch delete
        $this->customerRepository->batchDelete($customerIds);
    }

    /**
     * Validate customers data.
     *
     * @param array $data
     * @throws ValidationException
     */
}
