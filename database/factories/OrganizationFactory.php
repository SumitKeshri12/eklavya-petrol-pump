<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'name' => $this->faker->unique()->text(5),
            'owner_name' => $this->faker->unique()->text(5),
            'contact_number' => $this->faker->numberBetween(1, 100),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->unique()->text(5),
            'state' => $this->faker->unique()->text(5),
            'city' => $this->faker->unique()->text(5),
            'pincode' => $this->faker->numberBetween(1, 100),
        ];
    }
}
