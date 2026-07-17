<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => 'INV-' . strtoupper(fake()->unique()->bothify('????-####')),
            'branch_id' => \App\Models\Branch::factory(),
            'user_id' => \App\Models\User::factory(),
            'customer_id' => \App\Models\Customer::factory(),
            'total_amount' => fake()->numberBetween(50000, 500000),
            'payment_method' => fake()->randomElement(['cash', 'card', 'qris']),
            'status' => 'Completed',
            //
        ];
    }
}
