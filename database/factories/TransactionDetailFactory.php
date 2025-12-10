<?php

namespace Database\Factories;

use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TransactionDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'transaction_id' => \App\Models\Transaction::inRandomOrder()->first()->id,
            '1_rupee' => $this->faker->unique()->numberBetween(1, 100),
            '2_rupee' => $this->faker->unique()->numberBetween(1, 100),
            '5_rupee' => $this->faker->unique()->numberBetween(1, 100),
            '10_rupee' => $this->faker->unique()->numberBetween(1, 100),
            '20_rupee' => $this->faker->unique()->numberBetween(1, 100),
            '50_rupee' => $this->faker->unique()->numberBetween(1, 100),
            '100_rupee' => $this->faker->unique()->numberBetween(1, 100),
            '200_rupee' => $this->faker->unique()->numberBetween(1, 100),
            '500_rupee' => $this->faker->unique()->numberBetween(1, 100),
        ];
    }
}
