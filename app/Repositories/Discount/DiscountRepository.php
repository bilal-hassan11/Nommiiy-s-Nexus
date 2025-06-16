<?php

namespace App\Repositories\Discount;

use App\Models\Discount;


class DiscountRepository
{

    protected $model;

    public function __construct(Discount $model)
    {
        $this->model = $model;
    }


    public function getAllWithPagination(array $filters, $perpage = 10)
    {
        $query = $this->model->query();
        if (isset($filters['name'])) {
            $query->where(
                'name',
                'like',
                '%' . $filters['name'] . '%'
            );
        }
        if (isset($filters['discount_value'])) {
            $query->where('discount_value', $filters['discount_value']);
        }
        if (isset($filters['discount_type'])) {
            $query->where('discount_type', $filters['discount_type']);
        }

        $perpage === 'all' ? $perpage = $query->count() : $perpage;
        return $query->paginate($perpage);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data)
    {
        $tax = $this->findById($id);

        if ($tax) {
            return $tax->update($data);
        }

        return false;
    }

    public function delete(int $id)
    {
        $shop = $this->findById($id);

        if ($shop) {
            return $shop->delete();
        }

        return false;
    }

    // Batch delete Shops and their contacts
    public function batchDelete(array $shopIds)
    {
        Discount::whereIn('id', $shopIds)->delete();
    }
}
