<?php

namespace App\Repositories\Shop;

use App\Models\Shop;

class ShopRepository
{
    protected $model;

    /**
     * ShopsRepository constructor.
     *
     * @param Shop $model
     */
    public function __construct(Shop $model)
    {
        $this->model = $model;
    }

    /**
     * Get all Shops.
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
     * Create a new Shops.
     *
     * @param array $data
     * @return Shop
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Find a Shops by ID.
     *
     * @param int $id
     * @return Shop|null
     */
    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Update a Shops.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data)
    {
        $shop = $this->findById($id);

        if ($shop) {
            return $shop->update($data);
        }

        return false;
    }

    /**
     * Delete a Shops by ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id)
    {
        $shop = $this->findById($id);

        if ($shop) {
            return $shop->delete();
        }

        return false;
    }



    public function updateStatus(int $id, string $status)
    {
        $shop = $this->findById($id);

        if ($shop) {
            return $shop->update(['status' => $status]);
        }

        return false;
    }


    // Batch delete Shops and their contacts
    public function batchDelete(array $shopIds)
    {
        Shop::whereIn('id', $shopIds)->delete();
    }
}
