<?php

namespace Database\Seeders;

use App\Models\Mood;
use Illuminate\Database\Seeder;

class MoodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mood::factory()
            ->count(10)
            ->create();
    }
}
