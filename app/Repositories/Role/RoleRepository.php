<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Models\PermissionRole;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;

class RoleRepository extends BaseRepository
{

    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function getPermissions(string $modelName): array
    {
        $table = (new $modelName())->getTable();
        $columns = Schema::getColumnListing($table);
        $groupedColumns = $this->groupColumnsByPrefix($columns);
       return $groupedColumns = ['data' => $groupedColumns];

    }

    private function groupColumnsByPrefix(array $columns): array
    {
        $grouped = [];

        foreach ($columns as $column) {
            if (strpos($column, '_can_') !== false) {
                $parts = explode('_', $column);
                $category = ucfirst($parts[0]);

                if (!isset($grouped[$category])) {
                    $grouped[$category] = [];
                }

                $grouped[$category][$column] = 0;
            }
        }

        return $grouped;
    }



    public function createRoleWithPermissions(array $data)
    {
        // Create the role
        $role = Role::create([
            'name' => $data['name'],
        ]);

        // Assign requested permissions to the role
        foreach ($data['permission_id'] as $permissionId) {
            PermissionRole::create([
                'permission_id' => $permissionId,
                'role_id' => $role->id,
            ]);
        }

        return $role;
    }





    
    public function updateRoleWithPermissions(array $data, int $id)
    {
        $role = $this->model->findOrFail($id);
        $role->update(['name' => $data['name']]);
        
        // Update the permissions
        $role->permissions()->sync($data['permission_id']);

        return $role;
    }
    
    
    

// RoleRepository.php
public function deleteRole(int $id): bool
{
    $role = $this->model->findOrFail($id);

    // Check if the role is associated with any users
    if ($role->users()->count() > 0) {
        throw new \Exception('You cannot delete this role because it is associated with one or more users.');
    }

    // Delete all permission-role associations for this role
    PermissionRole::where('role_id', $role->id)->delete();

    // Detach permissions associated with the role as a safeguard
    $role->permissions()->detach();

    // Delete the role
    return $role->delete();
}

// RoleService.php
public function deleteRoles(array $ids): array
{
    $undeletedRoles = [];
    
    // Check if any of the roles are assigned to users
    foreach ($ids as $id) {
        $role = $this->model->find($id);
        
        // If the role does not exist, continue
        if (!$role) {
            continue;
        }

        // Check if the role is associated with any users
        if ($role->users()->count() > 0) {
            $undeletedRoles[] = $role->name; // Collect undeleted role names
        }
    }

    // If there are any assigned roles, return the undeleted roles
    if (!empty($undeletedRoles)) {
        return $undeletedRoles; // Return undeleted roles if any are found
    }

    // If no roles are assigned, delete them all
    foreach ($ids as $id) {
        $role = $this->model->find($id);
        if ($role) {
            // Detach permissions associated with the role
            $role->permissions()->detach();
            // Delete the role
            $role->delete();
        }
    }

    return []; // Return an empty array if all roles were successfully deleted
}




    public function findWithPermissions(int $id)
    {
        return $this->model->with('permissions:id,name,module_name')->findOrFail($id);
    }



    public function paginateRole($modelClass, $perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
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
