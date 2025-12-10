<?php

namespace Database\Seeders;

use App\Models\FuelTest;
use Illuminate\Database\Seeder;

class FuelTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        FuelTest::factory()->count(5)->create();
    }
}
