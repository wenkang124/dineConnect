<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BannerFactory extends Factory
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
            'description' => fake()->text(50),
            'action' => array_key_last(Banner::TYPE_LIST),
            'active' => rand(0, 1),
            'sequence' => 1,
        ];
    }
}
