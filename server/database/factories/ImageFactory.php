<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'filename' => $this->faker->word . '.' . $this->faker->fileExtension,
            'path' => $this->faker->filePath,
            'mime_type' => $this->faker->mimeType,
            'driver_test_id' => "1",
        ];
    }
}