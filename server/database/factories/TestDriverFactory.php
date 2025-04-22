<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestDriver>
 */
class TestDriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'user_id' => $this->faker->numberBetween(1, 5),
            'name' => $this->faker->name(),
            'color' => $this->faker->safeColorName(),
            'contact' => $this->faker->phoneNumber(),
            'showroom' => $this->faker->company(),
            'vehicle_type' => $this->faker->word(),
            'location' => $this->faker->address(),
            'start_time' => $this->faker->dateTimeBetween('2025-01-01', '2025-12-31')->format('Y-m-d H:i'),
            'end_time' => $this->faker->dateTimeBetween('2025-01-01', '2025-12-31')->format('Y-m-d H:i'),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'description' => $this->faker->paragraph(),
        ];
    }
}
