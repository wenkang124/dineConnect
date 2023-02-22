<?php

namespace Database\Seeders;

use App\Models\FilterOption;
use App\Models\MenuCategory;
use Illuminate\Database\Seeder;

class FilterOptionTableSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FilterOption::updateOrCreate(
            [
                'label' => 'Price',
                'min' => 0,
                'max' => 100,
            ]
        );
        FilterOption::updateOrCreate(
            [
                'label' => 'Distance',
                'min' => 0,
                'max' => 100,
            ]
        );
    }
}
