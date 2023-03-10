<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain>
 */
class DomainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->domainName,
            'type' => $this->faker->randomElement(['subdomain', 'domain']),
            'dns_status' => $this->faker->randomElement(['pending', 'verified', 'failed']),
        ];
    }
}
