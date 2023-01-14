<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->name,
            'mobile' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'verify_code' => $this->faker->randomNumber(4),
            'last_send_sms_at' => $this->faker->dateTime,

        ];
    }
}
