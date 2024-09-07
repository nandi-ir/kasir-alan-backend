<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $makanan = [
            "Nasi Goreng",
            "Mie Ayam",
            "Sate Ayam",
            "Rendang",
            "Soto Ayam",
            "Gado-Gado",
            "Bakso",
            "Gudeg",
            "Ayam Bakar",
            "Pempek"
        ];

        return [
            'name' => fake()->randomElement($makanan),
            'price' => fake()->numberBetween(1, 20) * 5000,
            'image' => fake()->randomElement([
                'https://www.blibli.com/friends-backend/wp-content/uploads/2023/04/B300026-Cover-resep-nasi-goreng-scaled.jpg',
                null
            ])
        ];
    }
}
