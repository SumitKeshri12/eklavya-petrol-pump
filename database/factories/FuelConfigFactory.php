<?php

namespace Database\Factories;

use App\Models\FuelConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuelConfigFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FuelConfig::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'fuel_type' => $this->faker->unique()->randomElement(range('A', 'Z')),
            'price' => $this->faker->unique()->text(5),
            'date' => $this->faker->date(),
        ];
    }
}
