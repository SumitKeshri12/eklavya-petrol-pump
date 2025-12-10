<?php

namespace Database\Seeders;

use App\Models\FuelConfig;
use Illuminate\Database\Seeder;

class FuelConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        FuelConfig::factory()->count(5)->create();
    }
}
