<?php

namespace Database\Seeders;

use App\Models\Dispenser;
use Illuminate\Database\Seeder;

class DispenserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Dispenser::factory()->count(5)->create();
    }
}
