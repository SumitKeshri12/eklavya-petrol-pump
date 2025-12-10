<?php

namespace Database\Factories;

use App\Models\Dispenser;
use Illuminate\Database\Eloquent\Factories\Factory;

class DispenserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dispenser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'number' => $this->faker->unique()->text(5),
            'nozzle_number' => $this->faker->unique()->text(5),
            'fuel_type' => $this->faker->unique()->randomElement(range('A', 'Z')),
            'status' => $this->faker->unique()->randomElement(range('A', 'Z')),
        ];
    }
}
