<?php

namespace App\Repositories\Supplier;

use App\Models\Supplier;

class SupplierRepository
{
    protected $model;

    /**
     * SupplierRepository constructor.
     *
     * @param Supplier $model
     */
    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }

    /**
     * Get all suppliers.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllWithPagination(array $filters, int $perPage = 10)
    {
        $query = $this->model->newQuery();

        // Filtering by name
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        // Filtering by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Additional filters can be added similarly

        return $query->paginate($perPage);
    }

    /**
     * Create a new supplier.
     *
     * @param array $data
     * @return Supplier
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Find a supplier by ID.
     *
     * @param int $id
     * @return Supplier|null
     */
    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Update a supplier.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data)
    {
        $supplier = $this->findById($id);

        if ($supplier) {
            return $supplier->update($data);
        }

        return false;
    }

    /**
     * Delete a supplier by ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id)
    {
        $supplier = $this->findById($id);

        if ($supplier) {
            return $supplier->delete();
        }

        return false;
    }



    public function updateStatus(int $id, string $status)
    {
        $supplier = $this->findById($id);

        if ($supplier) {
            return $supplier->update(['status' => $status]);
        }

        return false;
    }


    // Batch delete suppliers and their contacts
    public function batchDelete(array $supplierIds)
    {
        Supplier::whereIn('id', $supplierIds)->delete();
    }
}
