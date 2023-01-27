<?php

namespace Database\Seeders;

use App\Models\MerchantMood;
use Illuminate\Database\Seeder;

class MerchantMoodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MerchantMood::factory()
            ->count(10)
            ->create();
    }
}
