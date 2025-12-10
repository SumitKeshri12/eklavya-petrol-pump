<?php

namespace Database\Factories;

use App\Models\PartyDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartyDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PartyDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'owner_name_1' => $this->faker->sentence,
            'owner_1_mobile' => $this->faker->sentence,
            'owner_name_2' => $this->faker->sentence,
            'owner_2_mobile' => $this->faker->sentence,
            'owner_name_3' => $this->faker->sentence,
            'owner_3_mobile' => $this->faker->sentence,
            'manager_name' => $this->faker->sentence,
            'manager_mobile' => $this->faker->sentence,
            'contact_name' => $this->faker->sentence,
            'contact_mobile' => $this->faker->sentence,
        ];
    }
}
