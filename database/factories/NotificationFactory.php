<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'title' => $this->faker->sentence,
            'message' => $this->faker->word(),
            'read_status' => $this->faker->word(),
            'button_name' => $this->faker->sentence,
            'button_link' => $this->faker->sentence,
        ];
    }
}
