<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => \App\Models\VehicleCategory::factory(),
            'name' => fake()->word() . ' ' . fake()->word(),
            'brand' => fake()->randomElement(['Toyota', 'Honda', 'Suzuki', 'Mitsubishi', 'Daihatsu']),
            'license_plate' => strtoupper(fake()->bothify('? #### ???')),
            'price_per_day' => fake()->numberBetween(100, 1000) * 1000,
            'status' => fake()->randomElement(['available', 'rented', 'maintenance']),
        ];
    }
}
