<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use App\Models\Merchant;
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
        // MerchantMenuCategory::updateOrCreate(
        //     [
        //         'merchant_id' => 10,
        //         'menu_category_id' => 1,
        //     ]
        // );
        // MerchantMenuCategory::updateOrCreate(
        //     [
        //         'merchant_id' => 10,
        //         'menu_category_id' => 2,
        //     ]
        // );
        $merchants = Merchant::get();
        foreach($merchants as $merchant) {
            $menu_categories = MenuCategory::pluck('id')->toArray();
            $merchant->menuCategories()->sync($menu_categories);
        }
    }
}
