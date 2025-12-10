<?php

namespace Database\Seeders;

use App\Models\JsmApiLog;
use Illuminate\Database\Seeder;

class JsmApiLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        JsmApiLog::factory()->count(5)->create();
    }
}
