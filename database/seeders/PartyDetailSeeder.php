<?php

namespace Database\Seeders;

use App\Models\PartyDetail;
use Illuminate\Database\Seeder;

class PartyDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        PartyDetail::factory()->count(5)->create();
    }
}
