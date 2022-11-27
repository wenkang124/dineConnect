<?php

namespace Database\Seeders;

use App\Models\MerchantCategory;
use Illuminate\Database\Seeder;

class MerchantCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MerchantCategory::factory()
            ->count(10)
            ->create();
    }
}
