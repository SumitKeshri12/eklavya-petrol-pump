<?php

namespace Database\Factories;

use App\Models\DemandProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemandProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DemandProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'demand_id' => \App\Models\Demand::inRandomOrder()->first()->id,
            'product_id' => \App\Models\Product::inRandomOrder()->first()->id,
            'quantity' => $this->faker->word(),
        ];
    }
}
