<?php

namespace Database\Factories;

use App\Models\Demand;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Demand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'fuel_type' => $this->faker->unique()->randomElement(range('A', 'Z')),
            'demand_date' => $this->faker->date(),
            'with_vehicle' => $this->faker->unique()->randomElement(range('A', 'Z')),
            'vehicle_number' => $this->faker->unique()->text(5),
            'receiver_mobile_no' => $this->faker->numberBetween(1, 100),
            'fuel_quantity' => $this->faker->numberBetween(1, 100),
            'quantity_fullfill' => $this->faker->word(),
            'outstanding_quantity' => $this->faker->word(),
            'status' => $this->faker->word(),
            'shift_id' => \App\Models\Shift::inRandomOrder()->first()->id,
            'nozzle_id' => \App\Models\DispenserNozzle::inRandomOrder()->first()->id,
            'receipt_image' => $this->faker->sentence,
            'product_image' => $this->faker->sentence,
            'driver_image' => $this->faker->sentence,
            'vehicle_image' => $this->faker->sentence,
            'product_id' => \App\Models\Product::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
