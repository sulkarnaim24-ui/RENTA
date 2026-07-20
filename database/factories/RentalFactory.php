<?php

namespace Database\Factories;

use App\Models\Rental;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 month', '+1 month');
        $end = fake()->dateTimeBetween($start, '+1 month');
        $startDate = \Carbon\Carbon::parse($start);
        $endDate = \Carbon\Carbon::parse($end);
        
        if ($endDate->lt($startDate)) {
            $endDate = $startDate->copy()->addDays(fake()->numberBetween(1, 5));
        }
        
        $totalDays = $startDate->diffInDays($endDate) + 1;
        
        $customer = \App\Models\User::where('role', 'customer')->inRandomOrder()->first() ?? \App\Models\User::factory()->create(['role' => 'customer']);
        $vehicle = \App\Models\Vehicle::inRandomOrder()->first();
        $driver = fake()->boolean(50) ? \App\Models\Driver::inRandomOrder()->first() : null;
        
        $totalPrice = $vehicle->price_per_day * $totalDays;
        if ($driver) {
            $totalPrice += $driver->cost_per_day * $totalDays;
        }

        return [
            'customer_id' => $customer->id,
            'vehicle_id' => $vehicle->id,
            'driver_id' => $driver ? $driver->id : null,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_days' => $totalDays,
            'total_price' => $totalPrice,
            'status' => fake()->randomElement(['pending', 'paid', 'active', 'completed', 'cancelled']),
        ];
    }
}
