<?php

namespace Database\Factories;

use App\Models\MaintenanceRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MaintenanceRecord>
 */
class MaintenanceRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-6 months', 'now');
        $maintenanceDate = \Carbon\Carbon::parse($date);
        
        return [
            'vehicle_id' => \App\Models\Vehicle::inRandomOrder()->first()->id ?? \App\Models\Vehicle::factory()->create()->id,
            'maintenance_date' => $maintenanceDate,
            'description' => fake()->sentence(6),
            'cost' => fake()->numberBetween(100, 5000) * 1000,
            'next_maintenance_date' => fake()->boolean(70) ? $maintenanceDate->copy()->addMonths(fake()->numberBetween(3, 6)) : null,
        ];
    }
}
