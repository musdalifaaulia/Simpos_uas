<?php

namespace Database\Factories;

use App\Models\StockTransfer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockTransfer>
 */
class StockTransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference_number' => 'TRF-' . strtoupper(fake()->unique()->bothify('????-####')),
            'from_branch_id' => \App\Models\Branch::factory(),
            'to_branch_id' => \App\Models\Branch::factory(),
            'product_id' => \App\Models\Product::factory(),
            'quantity' => fake()->numberBetween(5, 20),
            'status' => fake()->randomElement(['Pending', 'Completed', 'Cancelled']),
            //
        ];
    }
}
