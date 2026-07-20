<?php

namespace Database\Factories;

use App\Models\InsuranceRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InsuranceRecord>
 */
class InsuranceRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vehicle = \App\Models\Vehicle::inRandomOrder()->first() ?? \App\Models\Vehicle::factory()->create();
        $isExpired = fake()->boolean(40);
        $startDate = $isExpired ? fake()->dateTimeBetween('-2 years', '-1 year') : fake()->dateTimeBetween('-1 year', 'now');
        $endDate = $isExpired ? fake()->dateTimeBetween('-1 month', 'yesterday') : fake()->dateTimeBetween('tomorrow', '+1 year');
        
        return [
            'vehicle_id' => $vehicle->id,
            'policy_number' => 'POL-' . fake()->unique()->numerify('#####-####'),
            'provider' => fake()->randomElement(['Garda Oto', 'Jasindo', 'Allianz', 'ACA', 'Zurich', 'Sinarmas']),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'premium_cost' => fake()->numberBetween(10, 50) * 100000,
            'document_file' => null,
        ];
    }
}
