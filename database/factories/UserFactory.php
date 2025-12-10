<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'role_id' => \App\Models\Role::inRandomOrder()->first()->id,
            'user_code' => $this->faker->sentence,
            'user_type' => $this->faker->word(),
            'party_type' => $this->faker->unique()->randomElement(range('A', 'Z')),
            'first_name' => $this->faker->unique()->text(5),
            'last_name' => $this->faker->unique()->text(5),
            'party_name' => $this->faker->unique()->text(5),
            'email' => $this->faker->unique()->safeEmail(),
            'mobile_number' => $this->faker->unique()->text(5),
            'password' => bcrypt('123456'),
            'aadhar_no' => $this->faker->numberBetween(1, 100),
            'esic_number' => $this->faker->numberBetween(1, 100),
            'pancard' => $this->faker->unique()->text(5),
            'profile' => $this->faker->word(),
            'bank_name' => $this->faker->unique()->text(5),
            'account_number' => $this->faker->numberBetween(1, 100),
            'ifsc_code' => $this->faker->unique()->text(5),
            'account_holder_name' => $this->faker->unique()->text(5),
            'gstin' => $this->faker->unique()->text(5),
            'tan_number' => $this->faker->unique()->text(5),
            'status' => $this->faker->unique()->randomElement(range('A', 'Z')),
            'last_login_at' => $this->faker->dateTime(),
            'locale' => $this->faker->word(),
        ];
    }
}
