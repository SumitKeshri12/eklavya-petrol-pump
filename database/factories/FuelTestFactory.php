<?php

namespace Database\Factories;

use App\Models\FuelTest;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuelTestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FuelTest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'shift_id' => \App\Models\Shift::inRandomOrder()->first()->id,
            'shift_nozzle_reading_id' => \App\Models\ShiftNozzleReading::inRandomOrder()->first()->id,
            'test_reading_start' => $this->faker->word(),
            'test_reading_end' => $this->faker->word(),
            'test_reading_liters' => $this->faker->word(),
        ];
    }
}
