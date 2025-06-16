<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Role\RoleService;
use App\Http\Controllers\Controller;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Database\QueryException;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }


    public function index(Request $request): JsonResponse
    {
        try {
            return response()->json(
                $this->roleService->paginateRoleFilter($request),
                ApiResponseCodeEnum::OK->value

            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }



    public function store(StoreRoleRequest $request): JsonResponse
    {
        try {
            $role = $this->roleService->storeRole($request->validated());
            $rele_id = $role->id;

            return response()->json([
                'message' => 'Role Permission created successfully',
                 'data'=>$rele_id
            ], ApiResponseCodeEnum::OK->value); // Use HTTP status 201 Created

        } catch (QueryException $ex) {
            return response()->json([
                'message' => 'The Role name already exists for this user.'
            ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            // Retrieve the role data
            $roleData = $this->roleService->getRole($id);

            return response()->json([ 'data' => $roleData], ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(
                ['message' => $th->getMessage()],
                ApiResponseCodeEnum::NOT_FOUND->value
            );
        }
    }


    public function update(UpdateRoleRequest $request, int $id): JsonResponse
    {
        try {
            $role = $this->roleService->updateRole($request->validated(), $id);


            return response()->json(['message' => 'Role updated successfully'], ApiResponseCodeEnum::OK->value);
        } catch (QueryException $ex) {
            return response()->json([
                'message' => 'The Role name already exists for this user.'
            ], ApiResponseCodeEnum::UNPROCESSABLE_ENTITY->value);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }


    public function destroy(int $id): JsonResponse
    {
        try {
            $this->roleService->deleteRole($id);

            return response()->json([
                'message' => 'Role deleted successfully',
            ], ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(
                ['message' => $th->getMessage()],
                ApiResponseCodeEnum::NOT_FOUND->value
            );
        }
    }


  // RoleController.php
public function destroyMultiple(Request $request)
{
    $ids = $request->query('ids');

    if (empty($ids) || !is_array($ids) || empty($ids[0])) {
        return response()->json(['message' => 'Invalid input. Please provide role IDs.'], ApiResponseCodeEnum::BAD_REQUEST->value);
    }

    $decodedIds = json_decode($ids[0], true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return response()->json(['message' => 'Invalid ID format.'], ApiResponseCodeEnum::BAD_REQUEST->value);
    }

    try {
        // Get undeleted roles from the service
        $undeletedRoles = $this->roleService->deleteRoles($decodedIds);

        // If there are undeleted roles, return a response indicating failure
        if (!empty($undeletedRoles)) {
            return response()->json([
                'message' => 'Some roles could not be deleted as they are assigned to users.',
                'undeleted_roles' => array_map(function ($roleName) {
                    return "The role '{$roleName}' cannot be deleted as it is assigned to users.";
                }, $undeletedRoles),
            ], ApiResponseCodeEnum::BAD_REQUEST->value);
        }

        return response()->json(['message' => 'Roles deleted successfully'], ApiResponseCodeEnum::OK->value);
    } catch (\Throwable $th) {
        return response()->json(
            ['message' => $th->getMessage()],
            ApiResponseCodeEnum::NOT_FOUND->value
        );
    }
}

}
