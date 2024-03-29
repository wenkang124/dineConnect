<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use App\Models\Merchant;
use Illuminate\Database\Seeder;

class MerchantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Merchant::factory()
            ->count(10)
            ->create();
    }
}
