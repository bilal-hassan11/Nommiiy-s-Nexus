<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create([
            'name' => 'super admin'
        ]);

        // Fetch all permissions
        $permissions = Permission::all();

        // Sync the Super Admin role with all permissions
        $role->permissions()->sync($permissions->pluck('id'));
    }
}
