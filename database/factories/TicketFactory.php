<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'is_answer' => $this->faker->boolean,
            'guest_name' => $this->faker->name,
            'guest_mobile' => $this->faker->phoneNumber,
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
        ];
    }
}
