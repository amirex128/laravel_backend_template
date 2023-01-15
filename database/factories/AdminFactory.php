<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{
    public function definition(): array
    {
        return [
            'mobile' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'password' => Hash::make('123456789'),
            'full_name' => $this->faker->name,
            'roles' => [
                'all'
            ],

        ];
    }
}
