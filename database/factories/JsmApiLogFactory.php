<?php

namespace Database\Factories;

use App\Models\JsmApiLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class JsmApiLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JsmApiLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'auth_token' => $this->faker->paragraph(),
            'ip_address' => $this->faker->sentence,
            'api_url' => $this->faker->sentence,
            'request_data' => $this->faker->paragraph(),
            'is_response_success' => $this->faker->word(),
            'response_data' => $this->faker->word(),
        ];
    }
}
