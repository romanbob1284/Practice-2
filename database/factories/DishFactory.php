<?php

namespace Database\Factories;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dish>
 */
class DishFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->text(fake()->numberBetween(5, 25)),
            'description' => fake()->paragraph(3),
            'price' => fake()->randomFloat(2, 100, 2000),
            'quantity' => fake()->numberBetween(1, 4),
            'ingredients' => fake()->words(5),
        ];
    }
}
