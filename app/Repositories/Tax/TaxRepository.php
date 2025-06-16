<?php

namespace App\Repositories\Tax;

use App\Models\Tax;


class TaxRepository
{

    protected $model;

    public function __construct(Tax $model)
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
        if (isset($filters['tax_nature'])) {
            $query->where('tax_nature', $filters['tax_nature']);
        }
        if (isset($filters['tax_type'])) {
            $query->where('tax_type', $filters['tax_type']);
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
        $tax = $this->findById($id);

        if ($tax) {
            return $tax->delete();
        }

        return false;
    }

    // Batch delete Shops and their contacts
    public function batchDelete(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}
