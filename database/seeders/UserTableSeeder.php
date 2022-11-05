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
            'phone' => '0126260154',
            'otp' => bcrypt('otp'),
            'password' => bcrypt('otp'),
        ]);
    }
}
