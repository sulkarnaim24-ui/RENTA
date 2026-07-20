<?php

namespace Database\Factories;

use App\Models\FuelLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FuelLog>
 */
class FuelLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vehicle = \App\Models\Vehicle::inRandomOrder()->first();
        $isRented = fake()->boolean(60);
        $rental = $isRented ? \App\Models\Rental::where('vehicle_id', $vehicle->id)->inRandomOrder()->first() : null;
        
        return [
            'vehicle_id' => $vehicle->id,
            'rental_id' => $rental ? $rental->id : null,
            'log_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'liters' => fake()->randomFloat(2, 5, 50),
            'cost' => fake()->numberBetween(50, 500) * 1000,
            'odometer' => fake()->numberBetween(1000, 50000),
        ];
    }
}
