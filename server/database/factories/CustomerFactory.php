<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'fullname' => $this->faker->name(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'address' => $this->faker->address(),
            'area' => $this->faker->city(),
            'email' => $this->faker->unique()->safeEmail(),
            'img' => $this->faker->imageUrl(),
            'hobbit' => $this->faker->word(),
            'income' => $this->faker->randomFloat(2, 1000, 10000),
            'members' => $this->faker->numberBetween(1, 10),
            'age' => $this->faker->numberBetween(18, 80),
            'owned' => $this->faker->randomElement(['yes', 'no']),
            'sex' => $this->faker->randomElement(['male', 'female']),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'type' => $this->faker->randomElement(['normal', 'vip']),
        ];
    }
}