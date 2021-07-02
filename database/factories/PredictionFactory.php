<?php

namespace Database\Factories;

use App\Models\Prediction;
use Illuminate\Database\Eloquent\Factories\Factory;

class PredictionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prediction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_id' => $this->faker->numberBetween($min = 1, $max = 1000),
            'market_type' => $this->faker->randomElement(['correct_score', '1x2']),
            'prediction' => $this->faker->sentence(1),
            'status' => $this->faker->randomElement(['win', 'lost', 'unresolved']),

        ];
    }
}
