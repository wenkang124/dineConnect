<?php

namespace Database\Seeders;

use App\Models\UserSearch;
use Illuminate\Database\Seeder;

class UserSearchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserSearch::factory()
            ->count(10)
            ->create();
    }
}
