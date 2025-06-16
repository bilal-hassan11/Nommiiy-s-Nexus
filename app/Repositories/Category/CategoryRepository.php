<?php

namespace App\Repositories\Category;

use App\Models\ProductCategory;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;

class CategoryRepository extends BaseRepository
{
    public function __construct(ProductCategory $category)
    {
        parent::__construct($category);
    }

    public function deleteCategory(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function getCategoryFilter($modelClass, $perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
    {
        // Dynamically instantiate the model class
        $query = app($modelClass)->newQuery();
        // Apply selected columns
        $query->select($columns);
        // Apply search term if provided
        if (!empty($conditions['searchTerm'])) {
            $query->where(function ($q) use ($conditions) {
              
                    // Filter by name
                    $q->where('name', 'like', "%{$conditions['searchTerm']}%");
            });
        }
        // Apply sorting if the column exists
        if (Schema::hasColumn(app($modelClass)->getTable(), $sortBy)) {
            $query->orderBy($sortBy, $sortOrder);
        }
        // Paginate the results
        return $query->paginate($perPage, $columns);
    }

}