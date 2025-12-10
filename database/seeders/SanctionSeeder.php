<?php

namespace Database\Seeders;

use App\Models\Sanction;
use Illuminate\Database\Seeder;

class SanctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Sanction::factory()->count(5)->create();
    }
}
