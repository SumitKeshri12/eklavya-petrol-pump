<?php

namespace Database\Factories;

use App\Models\PushNotificationTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class PushNotificationTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PushNotificationTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'type' => $this->faker->unique()->text(5),
            'label' => $this->faker->unique()->text(5),
            'title' => $this->faker->unique()->text(5),
            'body' => $this->faker->paragraph(),
            'image' => $this->faker->word(),
            'button_name' => $this->faker->unique()->text(5),
            'button_link' => $this->faker->unique()->text(5),
            'status' => $this->faker->unique()->randomElement(range('A', 'Z')),
        ];
    }
}
