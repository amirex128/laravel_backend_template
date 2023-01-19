<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => $this->faker->word,
            'started_at' => $this->faker->dateTime,
            'ended_at' => $this->faker->dateTime,
            'count' => $this->faker->numberBetween(9,100),
            'value' => $this->faker->numberBetween(9,100000),
            'percent' => $this->faker->numberBetween(0,100),
            'status' => $this->faker->boolean,
            'type' => $this->faker->randomElement(['percent', 'amount']),
        ];
    }
}
