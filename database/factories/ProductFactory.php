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
            'block_status' => $this->faker->randomElement(['block', 'ok']),
        ];
    }
}
