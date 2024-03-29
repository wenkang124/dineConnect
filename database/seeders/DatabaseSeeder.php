<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminTableSeeder::class,
            // UserTableSeeder::class,
            // PreferenceTableSeeder::class,
            // BannerTableSeeder::class,
            CategoryTableSeeder::class,
            // MoodTableSeeder::class,
            // MerchantTableSeeder::class,
            // UserSearchTableSeeder::class,
            CountryTableSeeder::class,
            MerchantCategoryTableSeeder::class,
            MenuCategoryTableSeeder::class,
            // MerchantMenuCategoryTableSeeder::class,
            // MerchantMoodTableSeeder::class,
            FilterOptionTableSeeder::class,
            ReportReasonTableSeeder::class
        ]);
    }
}
