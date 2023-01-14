<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
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
            'social_address' => $this->faker->userName,
            'description' => $this->faker->sentence,
            'phone' => $this->faker->phoneNumber,
            'mobile' => $this->faker->phoneNumber,
            'telegram_id' => $this->faker->userName,
            'instagram_id' => $this->faker->userName,
            'whatsapp_id' => $this->faker->userName,
            'email' => $this->faker->email,
            'website' => $this->faker->url,
            'send_price' => $this->faker->numberBetween(0, 1000),
            'type' => $this->faker->randomElement(['instagram', 'telegram', 'website']),

        ];
    }
}
