<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'mobile' => $this->faker->phoneNumber,
            'full_name' => $this->faker->name,
            'lat' => $this->faker->latitude,
            'long' => $this->faker->longitude,
        ];
    }
}
