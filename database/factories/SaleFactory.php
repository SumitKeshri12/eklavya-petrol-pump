<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'shift_id' => \App\Models\Shift::inRandomOrder()->first()->id,
            'nozzle_id' => \App\Models\DispenserNozzle::inRandomOrder()->first()->id,
            'date' => $this->faker->date(),
            'test_ltr' => $this->faker->word(),
            'cash_collected' => $this->faker->word(),
            'online_collected' => $this->faker->word(),
            'credit_sales' => $this->faker->word(),
            'petrol_consumed' => $this->faker->word(),
            'diesel_consumed' => $this->faker->word(),
        ];
    }
}
