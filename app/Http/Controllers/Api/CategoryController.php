<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request): JsonResponse
    {
        try {
            $items = $this->categoryService->getCategoriesWithFilters($request);
            // Return paginated response
            return response()->json($items, ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }



    /**
     * Store a newly created resource in storage.
     */



    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $createdCategory = $this->categoryService->create($data);
            $category_id = $createdCategory->id;

            return response()->json([
                'message' => 'Category created successfully',
                'data' => $category_id
            ], ApiResponseCodeEnum::CREATED->value);
        } catch (QueryException $ex) {
            return response()->json([
                'message' => 'The category name already exists.'
            ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {

        try {

            $data = $this->categoryService->getById($id);

            return response()->json([ 'data' => $data,
        ],ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {

            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id): JsonResponse
    {

        try {

            $data = $request->validated();
            $this->categoryService->update($id, $data);
            return response()->json([
                'message' => 'Category updated successfully',
            ], ApiResponseCodeEnum::CREATED->value);
        } catch (QueryException $ex) {
            return response()->json([
                'message' => 'The category name already exists.'
            ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {

        try {

            $this->categoryService->delete($id);

            return response()->json(['message' => 'Category deleted successfully'], ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {

            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::SERVER_ERROR->value);
        }
    }



    public function destroyMultiple(Request $request)
    {

        $ids = $request->query('ids');

        if (empty($ids) || !is_array($ids) || empty($ids[0])) {
            return response()->json(['message' => 'Invalid input. Please provide user IDs.'], ApiResponseCodeEnum::BAD_REQUEST->value);
        }

        $decodedIds = json_decode($ids[0], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['message' => 'Invalid ID format.'], ApiResponseCodeEnum::BAD_REQUEST->value);
        }

        try {
            $this->categoryService->deleteCategory($decodedIds);

            return response()->json([
                'message' => 'Batch Category deleted successfully',
            ], ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(
                ['message' => $th->getMessage()],
                ApiResponseCodeEnum::NOT_FOUND->value
            );
        }
    }
}
