<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MerchantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'thumbnail' => fake()->text(),
            'lat' => fake()->randomFloat(1, 10, 10),
            'lng' => fake()->randomFloat(1, 10, 11),
            'active' => rand(0, 1),
        ];
    }
}
