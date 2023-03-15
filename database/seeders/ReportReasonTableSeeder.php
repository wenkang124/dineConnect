<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\ReportReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportReasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReportReason::updateOrCreate([
            'title' => 'Nudity or sexual activity',
        ]);
        ReportReason::updateOrCreate([
            'title' => 'False information',
        ]);
        ReportReason::updateOrCreate([
            'title' => 'Bullying or harassment',
        ]);
        ReportReason::updateOrCreate([
            'title' => 'Hate speech or symbol',
        ]);
        ReportReason::updateOrCreate([
            'title' => 'Others',
            'is_other' => true,
        ]);
    }
}
