<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
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
            'customer_name' => fake()->randomElement([fake()->name(), null]),
            'status' => fake()->randomElement(['pending', 'paid']),
            'total_price' => fake()->numberBetween(1, 20) * 5000,
        ];
    }
}
