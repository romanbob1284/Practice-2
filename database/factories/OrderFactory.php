<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['active', 'inactive']),
            'payment_method' => fake()->randomElement(['cash', 'card']),
            'total_price' => fake()->randomFloat(2, 100, 2000),
        ];
    }
}
