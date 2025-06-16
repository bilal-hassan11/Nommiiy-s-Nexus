<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository
{
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }

    public function getPermissions(string $modelName): array
    {
        // Retrieve permissions ordered by id in ascending order
        $permissions = Permission::select('id', 'name', 'module_name')->orderBy('id', 'asc')->get()->toArray();

        // Group permissions by module_name
        $groupedPermissions = [];

        foreach ($permissions as $permission) {
            $moduleName = $permission['module_name'];

            // Initialize the module group if it doesn't exist
            if (!isset($groupedPermissions[$moduleName])) {
                $groupedPermissions[$moduleName] = [];
            }

            // Add the permission to the respective module group
            $groupedPermissions[$moduleName][] = [
                'id' => $permission['id'],
                'name' => str_replace('_', ' ', $permission['name'])
            ];
        }

        return $groupedPermissions; // Return the grouped array
    }







}
