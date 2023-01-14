<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ip' => $this->faker->ipv4,
            'total_product_price' => $this->faker->numberBetween(1000, 100000),
            'total_discount_price' => $this->faker->numberBetween(1000, 100000),
            'total_tax_price' => $this->faker->numberBetween(1000, 100000),
            'total_product_discount_price' => $this->faker->numberBetween(1000, 100000),
            'total_final_price' => $this->faker->numberBetween(1000, 100000),
            'send_price' => $this->faker->numberBetween(1000, 100000),
            'status' => $this->faker->randomElement(['pending', 'paid', 'shipped', 'delivered', 'canceled']),
            'description' => $this->faker->text,
            'package_size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'tracking_code' => $this->faker->uuid,
            'courier' => $this->faker->randomElement(['post', 'tipax', 'alopike']),
            'last_update_status_at' => $this->faker->dateTime,
            'weight' => $this->faker->numberBetween(1000, 100000),
        ];
    }
}
