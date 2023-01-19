<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'path' => $this->faker->imageUrl,
            'full_path' => $this->faker->imageUrl,
            'mime_type' => $this->faker->mimeType(),
            'size' => $this->faker->randomNumber(),
            'type' => $this->faker->randomElement(['image', 'video', 'file']),
        ];
    }
}
