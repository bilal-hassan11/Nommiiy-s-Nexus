<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'password' => Hash::make('password123'),
            'type' => 'Super admin',
            'status' => 'active'
        ]);
    }
}
