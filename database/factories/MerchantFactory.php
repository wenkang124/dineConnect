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
            'thumbnail' => 'https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg',
            'address' => fake()->text(),
            'postal_code' => rand(10000, 99999),
            'city' => fake()->text(),
            'state' => fake()->text(),
            'country_id' => 129,
            'lat' => fake()->randomFloat(1, 10, 10),
            'lng' => fake()->randomFloat(1, 10, 11),
            'active' => rand(0, 1),
        ];
    }
}
