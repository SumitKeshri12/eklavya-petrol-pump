<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'name' => $this->faker->unique()->text(5),
            'chr_code' => $this->faker->unique()->text(5),
            'hsn_code' => $this->faker->unique()->text(5),
            'category' => $this->faker->unique()->text(5),
            'unit' => $this->faker->unique()->randomElement(range('A', 'Z')),
            'tax_rate' => $this->faker->unique()->text(5),
            'cess' => $this->faker->unique()->text(5),
            'opening_quantity' => $this->faker->unique()->text(5),
            'opening_rate' => $this->faker->unique()->text(5),
            'purchase_rate' => $this->faker->unique()->text(5),
            'opening_value' => $this->faker->unique()->text(5),
            'selling_rate' => $this->faker->unique()->text(5),
        ];
    }
}
