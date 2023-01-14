<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'total_sales' => $this->faker->numberBetween(1000, 100000),
            'quantity' => $this->faker->numberBetween(1000, 100000),
            'price' => $this->faker->numberBetween(1000, 100000),
            'active' => $this->faker->boolean,
            'started_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'ended_at' => $this->faker->dateTimeBetween('+2 year', '+2 year'),
            'block_status' => $this->faker->randomElement(['block', 'ok']),
        ];
    }
}
