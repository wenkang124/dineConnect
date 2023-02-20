<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use Illuminate\Database\Seeder;

class MenuCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuCategory::updateOrCreate(
            [
                'name' => 'Food',
                'image' => asset('images/food.jpg'),
            ]
        );
        MenuCategory::updateOrCreate(
            [
                'name' => 'Beverage',
                'image' => asset('images/beverage.jpg'),
            ]
        );
    }
}
