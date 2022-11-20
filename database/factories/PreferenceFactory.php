<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'image' => 'https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg',
            'name' => fake()->unique()->name(),
            'active' => rand(0, 1),
        ];
    }
}
