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
            'status' => $this->faker->randomElement(['wait_for_pay','wait_for_try_pay','paid','wait_for_sender','wait_for_delivery','delivered','returned_timeout','wait_for_accept_returned','reject_returned','wait_for_sender_returned','delivered_returned','wait_for_returned_pay_back','returned_paid']),
            'description' => $this->faker->text,
            'package_size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'tracking_code' => $this->faker->uuid,
            'courier' => $this->faker->randomElement(['post', 'tipax', 'alopike']),
            'last_update_status_at' => $this->faker->dateTime,
            'weight' => $this->faker->numberBetween(1000, 100000),
        ];
    }
}
