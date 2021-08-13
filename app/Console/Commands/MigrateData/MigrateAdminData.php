<?php

namespace App\Console\Commands\MigrateData;

use App\Imports\AdminsImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MigrateAdminData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:admins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate admins table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('Start migrate admins table');
            $adminsPath = storage_path('/data-migrate/admins.csv');
            if (file_exists($adminsPath)) {
                Log::info('migrate admin from current system admins table');
                Excel::import(new AdminsImport(), $adminsPath);
                Log::info('migrate admin from current system admins table success');
            }
            $this->info('Start migrate admin tables');
        } catch (\Exception $exception) {
            $this->info($exception->getMessage());
        }

    }
}
