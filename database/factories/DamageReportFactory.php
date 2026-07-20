<?php

namespace Database\Factories;

use App\Models\DamageReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DamageReport>
 */
class DamageReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['reported', 'in_repair', 'resolved']);
        $hasRental = fake()->boolean(60);
        $rental = $hasRental ? \App\Models\Rental::inRandomOrder()->first() : null;
        $vehicle_id = $rental ? $rental->vehicle_id : (\App\Models\Vehicle::inRandomOrder()->first()->id ?? \App\Models\Vehicle::factory()->create()->id);

        return [
            'vehicle_id' => $vehicle_id,
            'rental_id' => $rental ? $rental->id : null,
            'description' => fake()->sentence(8),
            'photo' => null,
            'reported_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'repair_cost' => fake()->numberBetween(2, 50) * 100000,
            'status' => $status,
        ];
    }
}
