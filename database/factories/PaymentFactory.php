<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'verified', 'failed']);
        $rental = \App\Models\Rental::inRandomOrder()->first();
        
        return [
            'rental_id' => $rental ? $rental->id : \App\Models\Rental::factory(),
            'amount' => $rental ? $rental->total_price : fake()->numberBetween(500, 5000) * 1000,
            'payment_method' => fake()->randomElement(['cash', 'transfer', 'ewallet', 'credit_card']),
            'proof_of_payment' => null,
            'payment_date' => fake()->dateTimeBetween('-2 months', 'now'),
            'status' => $status,
        ];
    }
}
