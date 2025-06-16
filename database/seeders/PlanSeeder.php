<?php

namespace Database\Seeders;

use App\Models\Plans;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plans::create([
            'name' => 'Stellar',
            'amount' => 100,
            'description' => 'Description for Stellar'
        ]);

        Plans::create([
            'name' => 'Stellar Plus',
            'amount' => 150,
            'description' => 'Description for Stellar Plus'
        ]);

        Plans::create([
            'name' => 'Stellar Business',
            'amount' => 200,
            'description' => 'Description for Stellar Business'
        ]);
    }
}
