<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => bcrypt('password'), // or use Hash::make('password') if you have the Hash facade imported
            'role' => $this->faker->randomElement(['admin', 'user']),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
        ];
    }
}