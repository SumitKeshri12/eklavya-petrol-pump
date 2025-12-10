<?php

namespace Database\Factories;

use App\Models\Sanction;
use Illuminate\Database\Eloquent\Factories\Factory;

class SanctionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sanction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'month' => $this->faker->unique()->randomElement(range('A', 'Z')),
            'year' => $this->faker->date(),
            'fuel_type' => $this->faker->unique()->randomElement(range('A', 'Z')),
            'quantity' => $this->faker->numberBetween(1, 100),
            'remarks' => $this->faker->unique()->text(5),
        ];
    }
}
