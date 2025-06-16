<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $with = [], array $columns = ['*'], array $conditions = [])
    {
        $query = $this->model->query();

        // Apply conditions (filters, search)
        foreach ($conditions as $field => $value) {
            if (Schema::hasColumn($this->model->getTable(), $field)) {
                $query->where($field, $value);
            }
        }

        // Eager load relationships
        if (!empty($with)) {
            $query->with($with);
        }

        return $query->get($columns);
    }


    public function paginate($perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
    {

        $query = $this->model->query();

        // Apply conditions
        foreach ($conditions as $field => $value) {
            if (Schema::hasColumn($this->model->getTable(), $field)) {
                $query->where($field, 'like', "%$value%");
            }
        }

        
        // Eager load relationships
        if (!empty($with)) {
            $query->with($with);
        }

        // Apply sorting
        if (Schema::hasColumn($this->model->getTable(), $sortBy)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        return $query->paginate($perPage, $columns);
    }

    public function paginateDynamic($modelClass, $perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
    {
        // Dynamically instantiate the model class
        $query = app($modelClass)->newQuery();
    
        // Apply the CASE statement for 'is_active' column
        $query->selectRaw("
            *,
            CASE 
                WHEN is_active = 1 THEN 'Active'
                WHEN is_active = 0 THEN 'Inactive'
            END AS is_active_status
        ");
    
        // Apply search term across multiple fields if provided
        if (!empty($conditions['searchTerm']) && !empty($conditions['columns'])) {
            $searchTerm = $conditions['searchTerm'];
            $columns = $conditions['columns'];
    
            // Apply specific logic for 'Active' and 'Inactive' filtering
            $query->where(function ($q) use ($searchTerm, $columns) {
                if (strtolower($searchTerm) === 'active') {
                    // Filter for active records
                    $q->where('is_active', 1);
                } elseif (strtolower($searchTerm) === 'inactive') {
                    // Filter for inactive records
                    $q->where('is_active', 0);
                } else {
                    // Apply search to other columns
                    foreach ($columns as $column) {
                        $q->orWhere($column, 'like', "%{$searchTerm}%");
                    }
                }
            });
        }
    
        // Eager load relationships
        if (!empty($with)) {
            $query->with($with);
        }
    
        // Apply sorting if the column exists in the table
        if (Schema::hasColumn(app($modelClass)->getTable(), $sortBy)) {
            $query->orderBy($sortBy, $sortOrder);
        }
    
        // Paginate the results
        return $query->paginate($perPage, $columns);
    }
    






    public function find($id, array $with = [], array $columns = ['*'])
    {
        $query = $this->model->query();

        // Eager load relationships
        if (!empty($with)) {
            $query->with($with);
        }

        return $query->findOrFail($id, $columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);
        $model->delete();
        return true;
    }

    public function with(array $relations)
    {
        return $this->model->with($relations);
    }



    public function updateStatus(int $id, string $isActive)
    {
        $attribute = $this->model->findOrFail($id);

        if (Schema::hasColumn($this->model->getTable(), 'status')) {
            $attribute->status = $isActive;
        } else {
            throw new \Exception('No valid status column found.');
        }
    
        $attribute->save();
    
        return $attribute;
    }
    
   
}