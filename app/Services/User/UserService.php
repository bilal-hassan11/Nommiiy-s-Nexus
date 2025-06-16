<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Repositories\User\UserRepository;


class UserService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        // Pass the repository to the BaseService
        parent::__construct($userRepository);
        $this->userRepository = $userRepository;
    }

    public function createUser(array $data)
    {
        return $this->userRepository->createUser($data);
    }


    public function update($id, array $data)
    {
        // Call the repository to update the user
        return $this->userRepository->updatedUser($id, $data);
    }

    public function findById(int $id)
    {
        $item = $this->userRepository->getById($id);

        if ($item) {
            // Transform the image path to include public path if the image exists
            if ($item->image) {
                $item->image = asset('storage/profile/' . $item->image);
            }
        }

        return $item;
    }
    public function deleteUser(int $id)
    {
        $item = $this->userRepository->deleteUser($id);
        return $item;
    }
    public function deleteUsers(array $id)
    {
        $item = $this->userRepository->deleteUsers($id);
        return $item;
    }

    public function updateUser(int $id, array $data)
    {
        return $this->userRepository->updateUser($id, $data);
    }




    public function paginateUserFilter(Request $request)
    {
        // Retrieve filtering and sorting parameters from request
        $searchTerm = $request->input('name', '');
        $with = ['role']; // Load the 'role' relationship
        $columns = ['id', 'role_id', 'name', 'email', 'phone', 'image', 'status'];
        $perPage = $request->input('per_page', 10);
        $sortOrder = $request->input('sort_order', 'desc');
        $sortBy = $request->input('sort_by', 'id');

        // Ensure valid sort order and sort by column
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';
        $sortBy = in_array($sortBy, ['id', 'role_id', 'name', 'email', 'phone', 'image', 'status']) ? $sortBy : 'id';

        // Create filter array
        $filters = [
            'searchTerm' => $searchTerm,
        ];


        // Fetch filtered user data
        return $this->getUserFilter(User::class, $perPage, $with, $columns, $filters, $sortOrder, $sortBy);
    }

    public function getUserFilter($modelClass, $perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
    {
        // Fetch filtered and paginated results using repository
        $items = $this->userRepository->getUserFilter($modelClass, $perPage, $with, $columns, $conditions, $sortOrder, $sortBy);

        // Transform the image path to include public path for each user if the image exists
        foreach ($items as $item) {
            if ($item->image) {
                $item->image = asset('storage/profile/' . $item->image);
            }
        }


        return $items;
    }
}
