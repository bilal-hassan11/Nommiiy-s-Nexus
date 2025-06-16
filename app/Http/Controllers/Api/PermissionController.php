<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Services\Permission\PermissionService;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    public function index(): JsonResponse
{
    try {
        // Get array of permissions with id and name
        $permissions = $this->permissionService->getPermissions('App\Models\Permission');

        // Return the permissions directly
        return response()->json($permissions, ApiResponseCodeEnum::OK->value);
    } catch (\Throwable $th) {
        return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::SERVER_ERROR->value);
    }
}



}
