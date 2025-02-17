<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Excel;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import file in assets/import.xlsx';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = public_path('assets/import.xls');

        if (!file_exists($file)) {
            $this->error('File not found');
            return;
        }

        $this->info('Importing...');

        // Import logic here
        $excel = app(Excel::class);
        $excel->import(new \App\Imports\Merchant\Created, $file);
    }
}
