<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'name' => 'user',
            'email' => 'user@dineconnect.com',
            'mobile_prefix_id' => '129',
            'phone' => '126260154',
            'password' => bcrypt('1234'),
        ]);
    }
}
