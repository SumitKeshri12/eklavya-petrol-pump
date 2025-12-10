<?php

namespace Database\Seeders;

use App\Models\DemandProduct;
use Illuminate\Database\Seeder;

class DemandProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DemandProduct::factory()->count(5)->create();
    }
}
