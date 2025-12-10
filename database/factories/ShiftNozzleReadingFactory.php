<?php

namespace Database\Factories;

use App\Models\ShiftNozzleReading;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftNozzleReadingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShiftNozzleReading::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'shift_id' => \App\Models\Shift::inRandomOrder()->first()->id,
            'nozzle_number' => $this->faker->sentence,
            'start_reading' => $this->faker->word(),
            'end_reading' => $this->faker->word(),
            'total_dispensed' => $this->faker->word(),
            'total_amount' => $this->faker->word(),
        ];
    }
}
