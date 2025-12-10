<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'shift_id' => \App\Models\Shift::inRandomOrder()->first()->id,
            'vehicle_number' => $this->faker->sentence,
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'with_vehicle' => $this->faker->word(),
            'mobile_number' => $this->faker->sentence,
            'fuel_type' => $this->faker->word(),
            'payment_type' => $this->faker->word(),
            'payment_method' => $this->faker->word(),
            'volume_liters' => $this->faker->unique()->numberBetween(1, 100),
            'amount' => $this->faker->unique()->numberBetween(1, 100),
            'count' => $this->faker->unique()->numberBetween(1, 100),
            'remark' => $this->faker->sentence,
            'status' => $this->faker->word(),
        ];
    }
}
