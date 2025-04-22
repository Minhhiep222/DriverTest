<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Unique;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->unique()->numberBetween(0, 32),
            'start' => $this->faker->time(),
            'end' => $this->faker->time(),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
        ];
    }
}