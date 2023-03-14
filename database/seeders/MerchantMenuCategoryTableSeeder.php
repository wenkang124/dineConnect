<?php

namespace Database\Seeders;

use App\Models\MerchantMenuCategory;
use Illuminate\Database\Seeder;

class MerchantMenuCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MerchantMenuCategory::updateOrCreate(
            [
                'merchant_id' => 10,
                'menu_category_id' => 1,
            ]
        );
        MerchantMenuCategory::updateOrCreate(
            [
                'merchant_id' => 10,
                'menu_category_id' => 2,
            ]
        );
    }
}
