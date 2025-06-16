<?php

namespace App\Services\Shop;

use App\Imports\ShopImport;
use Illuminate\Http\Request;
use App\Enums\SupplierStatus;
use Illuminate\Support\Facades\DB;
use App\Repositories\Shop\ShopRepository;
use Illuminate\Validation\ValidationException;
use App\Services\Import\ImportExcelDataService;

class ShopService  extends ImportExcelDataService
{
    protected $shopRepository;

    /**
     * ShopService constructor.
     *
     * @param ShopRepository $ShopRepository
     */
    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    /**
     * Get a list of all Shops.
     *
     * @return mixed
     */
    public function getAllShops(array $filters, int $perPage = 10)
    {
        return $this->shopRepository->getAllWithPagination($filters, $perPage);
    }

    /**
     * Create a new Shops.
     *
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function createShop(array $data)
    {
        // Set default status if not provided
        $data['status'] = $data['status'] ?? SupplierStatus::ACTIVE->value;
        return $this->shopRepository->create($data);
    }



    public function importExcelData(Request $request): array
    {
        $file = $request->file('file'); // Get the uploaded file

        try {

            DB::beginTransaction();
            $importResult = $this->import(new ShopImport(), $file); // Pass the import class

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
     * Find a Shops by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function findShopById(int $id)
    {
        return $this->shopRepository->findById($id);
    }

    /**
     * Update an existing Shops.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function updateShop(int $id, array $data)
    {
        return $this->shopRepository->update($id, $data);
    }

    /**
     * Delete a Shops by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function deleteShop(int $id)
    {
        return $this->shopRepository->delete($id);
    }


    public function updateShopStatus(int $id, array $data)
    {
        return $this->shopRepository->updateStatus($id, $data['status']);
    }


    // Batch delete Shops and their contacts
    public function batchDeleteShops(array $shopIds)
    {
        // Call the repository to handle the batch delete
        $this->shopRepository->batchDelete($shopIds);
    }

    /**
     * Validate Shops data.
     *
     * @param array $data
     * @throws ValidationException
     */
}
