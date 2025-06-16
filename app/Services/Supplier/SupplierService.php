<?php

namespace App\Services\Supplier;

use Illuminate\Http\Request;

use App\Enums\SupplierStatus;
use App\Imports\SupplierImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\Import\ImportExcelDataService;
use App\Repositories\Supplier\SupplierRepository;

class SupplierService extends ImportExcelDataService
{
    protected $supplierRepository;

    /**
     * SupplierService constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * Get a list of all suppliers.
     *
     * @return mixed
     */
    public function getAllSuppliers(array $filters, int $perPage = 10)
    {
        return $this->supplierRepository->getAllWithPagination($filters, $perPage);
    }

    /**
     * Create a new supplier.
     *
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function createSupplier(array $data)
    {
           // Set default status if not provided
    $data['status'] = $data['status'] ?? SupplierStatus::ACTIVE->value;
        return $this->supplierRepository->create($data);
    }


    public function importExcelData(Request $request): array
    {
        $file = $request->file('file'); // Get the uploaded file

        try {

            DB::beginTransaction();
            $importResult = $this->import(new SupplierImport(), $file); // Pass the import class

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
     * Find a supplier by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function findSupplierById(int $id)
    {
        return $this->supplierRepository->findById($id);
    }

    /**
     * Update an existing supplier.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function updateSupplier(int $id, array $data)
    {
        return $this->supplierRepository->update($id, $data);
    }

    /**
     * Delete a supplier by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function deleteSupplier(int $id)
    {
        return $this->supplierRepository->delete($id);
    }


    public function updateSupplierStatus(int $id, array $data)
{
    return $this->supplierRepository->updateStatus($id, $data['status']);
}


  // Batch delete suppliers and their contacts
  public function batchDeleteSuppliers(array $supplierIds)
  {
      // Call the repository to handle the batch delete
      $this->supplierRepository->batchDelete($supplierIds);
  }

    /**
     * Validate supplier data.
     *
     * @param array $data
     * @throws ValidationException
     */

}
