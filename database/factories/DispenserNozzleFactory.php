<?php

namespace Database\Factories;

use App\Models\DispenserNozzle;
use Illuminate\Database\Eloquent\Factories\Factory;

class DispenserNozzleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DispenserNozzle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'dispenser_id' => \App\Models\Dispenser::inRandomOrder()->first()->id,
            'nozzle_number' => $this->faker->sentence,
            'fuel_type' => $this->faker->word(),
            'status' => $this->faker->word(),
        ];
    }
}
