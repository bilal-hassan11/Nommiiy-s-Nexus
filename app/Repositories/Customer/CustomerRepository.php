<?php

namespace App\Repositories\Customer;

use App\Models\Customer;

class CustomerRepository
{
    protected $model;

    /**
     * customersRepository constructor.
     *
     * @param Customer $model
     */
    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    /**
     * Get all customers.
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
     * Create a new customers.
     *
     * @param array $data
     * @return Customer
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * Find a customers by ID.
     *
     * @param int $id
     * @return Customer|null
     */
    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Update a customers.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data)
    {
        $customer = $this->findById($id);

        if ($customer) {
            return $customer->update($data);
        }

        return false;
    }

    /**
     * Delete a customers by ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id)
    {
        $customer = $this->findById($id);

        if ($customer) {
            return $customer->delete();
        }

        return false;
    }



    public function updateStatus(int $id, string $status)
    {
        $customer = $this->findById($id);

        if ($customer) {
            return $customer->update(['status' => $status]);
        }

        return false;
    }


    // Batch delete customers and their contacts
    public function batchDelete(array $customerIds)
    {
        Customer::whereIn('id', $customerIds)->delete();
    }
}
