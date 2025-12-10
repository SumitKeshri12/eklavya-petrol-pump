<?php

namespace Database\Seeders;

use App\Models\ShiftNozzleReading;
use Illuminate\Database\Seeder;

class ShiftNozzleReadingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ShiftNozzleReading::factory()->count(5)->create();
    }
}
