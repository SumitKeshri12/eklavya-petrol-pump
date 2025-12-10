<?php

namespace Database\Factories;

use App\Models\SmsTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class SmsTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SmsTemplate::class;

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
            'message' => $this->faker->paragraph(),
            'dlt_message_id' => $this->faker->unique()->text(5),
            'status' => $this->faker->unique()->randomElement(range('A', 'Z')),
        ];
    }
}
