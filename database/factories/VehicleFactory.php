<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'vehicle_number' => $this->faker->unique()->text(5),
            'fuel_type' => $this->faker->unique()->randomElement(range('A', 'Z')),
            'status' => $this->faker->unique()->randomElement(range('A', 'Z')),
        ];
    }
}
