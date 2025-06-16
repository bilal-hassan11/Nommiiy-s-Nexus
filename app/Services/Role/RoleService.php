<?php

namespace App\Services\Role;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Repositories\Role\RoleRepository;

class RoleService extends BaseService
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        parent::__construct($roleRepository);
        $this->roleRepository = $roleRepository;
    }

    public function getPermissions(string $modelName): array
    {
        return $this->roleRepository->getPermissions($modelName);
    }


    public function storeRole($data)
    {
        return $this->roleRepository->createRoleWithPermissions($data);
    }




    public function updateRole(array $data, int $id)
    {
        return $this->roleRepository->updateRoleWithPermissions($data, $id);
    }



    public function deleteRole(int $id): bool
    {
        return $this->roleRepository->deleteRole($id);
    }


    public function deleteRoles(array $ids)
    {
        return $this->roleRepository->deleteRoles($ids);
    }





    public function getRole(int $id): array
    {
        $role = $this->roleRepository->findWithPermissions($id);

        // Group permissions by `module_name`
        $permissionsByModule = $role->permissions->groupBy('module_name')->map(function ($permissions) {
            return $permissions->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => str_replace('_', ' ', $permission->name)
                ];
            })->toArray();
        })->toArray();

        // Return the role data with grouped permissions
        return [
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => $permissionsByModule,
        ];
    }



    public function paginateRole($modelClass, $perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
    {

        return $this->roleRepository->paginateRole($modelClass, $perPage, $with, $columns, $conditions, $sortOrder, $sortBy);
    }

    public function paginateRoleFilter(Request $request)
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
        return $this->paginateRole(Role::class, $perPage, [], $columns, $filters, $sortOrder, $sortBy);
    }
}
