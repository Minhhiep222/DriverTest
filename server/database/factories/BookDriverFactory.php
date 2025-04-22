<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookDriver>
 */
class BookDriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'driver_test_id' => $this->faker->numberBetween(1, 10),
            'fullname' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'date_drive' => $this->faker->date('Y-m-d'),
            'time_drive' => $this->faker->time(),
            'note' => $this->faker->optional()->sentence,
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
        ];
    }
}
