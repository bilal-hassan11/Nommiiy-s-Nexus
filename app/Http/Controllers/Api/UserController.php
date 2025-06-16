<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use App\Enums\Responses\ApiResponseCodeEnum;
use App\Http\Requests\User\ChangeStatusUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function index(Request $request): JsonResponse
    {
        try {

            // Fetch filtered user data
            $items = $this->userService->paginateUserFilter($request);

            // Return paginated response
            return response()->json($items, ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }


    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = $this->userService->createUser($data);

            return response()->json([
                'message' => 'User created successfully',
                'data' => $user->id
            ], ApiResponseCodeEnum::CREATED->value);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->userService->findById($id);

            return response()->json([ 'data' => $data], ApiResponseCodeEnum::OK->value);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::NOT_FOUND->value);
        }
    }

     // Update user method
     public function update(UpdateUserRequest $request, $id): JsonResponse
     {
         try {
             $data = $request->validated();
             $this->userService->updateUser($id, $data);

             return response()->json([
                 'message' => 'User updated successfully',
             ], ApiResponseCodeEnum::OK->value);
         } catch (\Throwable $th) {
             return response()->json(['message' => $th->getMessage()], ApiResponseCodeEnum::NOT_FOUND->value);
         }
     }


     public function destroy(int $id): JsonResponse
     {
         try {
             $this->userService->deleteUser($id);

             return response()->json([
                 'message' => 'User deleted successfully',
             ], ApiResponseCodeEnum::OK->value);
         } catch (\Throwable $th) {
             return response()->json(
                 ['message' => $th->getMessage()],
                 ApiResponseCodeEnum::NOT_FOUND->value
             );
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
             $this->userService->deleteUsers($decodedIds);

             return response()->json([
                 'message' => 'Users deleted successfully',
             ], ApiResponseCodeEnum::OK->value);
         } catch (\Throwable $th) {
             return response()->json(
                 ['message' => $th->getMessage()],
                 ApiResponseCodeEnum::NOT_FOUND->value
             );
         }
     }

     public function changeStatus(int $id, ChangeStatusUserRequest $request): JsonResponse
     {
         try {
             // Retrieve validated data from the request
             $data = $request->validated();

             // Change the status of the user using the service
             $this->userService->changeStatus($id, $data['status']);

             // Return a success response
             return response()->json([
                 'message' => 'User status changed successfully',
             ], ApiResponseCodeEnum::OK->value);
         } catch (\Throwable $th) {
             // Handle any exceptions and return an error response
             return response()->json([
                 'message' => $th->getMessage(),
             ], ApiResponseCodeEnum::NOT_FOUND->value);
         }

     }


}
