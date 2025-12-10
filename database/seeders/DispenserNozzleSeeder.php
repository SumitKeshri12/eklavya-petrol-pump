<?php

namespace Database\Seeders;

use App\Models\DispenserNozzle;
use Illuminate\Database\Seeder;

class DispenserNozzleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DispenserNozzle::factory()->count(5)->create();
    }
}
