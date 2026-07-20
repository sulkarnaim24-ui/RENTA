<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'license_number' => fake()->numerify('SIM-########'),
            'status' => fake()->randomElement(['available', 'assigned', 'leave']),
            'cost_per_day' => fake()->numberBetween(100, 300) * 1000,
        ];
    }
}
