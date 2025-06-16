<?php

namespace App\Services\Category;

use App\Services\BaseService;
use App\Models\ProductCategory;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;

class CategoryService extends BaseService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        // Pass the repository to the BaseService
        parent::__construct($categoryRepository);
        $this->categoryRepository = $categoryRepository;
    }

    public function deleteCategory(array $ids)
    {
        return $this->categoryRepository->deleteCategory($ids);
    }

    public function getCategoryFilter($modelClass, $perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
    {
        // Fetch filtered and paginated results using repository
        return $this->categoryRepository->getCategoryFilter($modelClass, $perPage, $with, $columns, $conditions, $sortOrder, $sortBy);
    }

    public function getCategoriesWithFilters(Request $request)
    {
        // Retrieve filtering and sorting parameters from request
        $searchTerm = $request->input('name', '');
        $columns = ['id', 'name'];
        $perPage = $request->input('per_page', 10);
        $sortOrder = $request->input('sort_order', 'desc');
        $sortBy = $request->input('sort_by', 'id');

        // Ensure valid sort order and sort by column
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';
        $sortBy = in_array($sortBy, ['id', 'name']) ? $sortBy : 'id';

        // Create filter array
        $filters = [
            'searchTerm' => $searchTerm,
        ];

        // Fetch filtered user data
        return $this->getCategoryFilter(ProductCategory::class, $perPage, [], $columns, $filters, $sortOrder, $sortBy);
    }
   
}