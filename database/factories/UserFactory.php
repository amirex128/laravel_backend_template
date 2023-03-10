<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'remember_token' => Str::random(10),
            'gender' => $this->faker->randomElement(['man', 'woman']),
            'full_name' => $this->faker->name(),
            'mobile' => $this->faker->phoneNumber(),
            'expire_at' => $this->faker->dateTimeBetween('+3 years', '+5 years'),
            'status' => $this->faker->randomElement(['ok', 'block']),
            'verify_code' => $this->faker->numberBetween(1000, 9999),
            'cart_number' => $this->faker->numberBetween(1000, 9999),
            'shaba' => $this->faker->numberBetween(1000, 9999),
            'is_admin' => $this->faker->boolean(),
            'last_send_sms_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withPersonalTeam(): static
    {
        if (!Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name . '\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }
}
