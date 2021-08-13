<?php

namespace App\Console\Commands\MigrateData;

use App\Imports\Prefecture\UserPreferredAreasImport;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class MigrateUserPreferredAreasData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:user-preferred-places';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate user preferred places data';

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
     * @return void
     */
    public function handle()
    {
        try {
            $this->info('Start migrate');
            $userPreferredPlacesPath = storage_path('/data-migrate/user_preferred_places.csv');
            if (file_exists($userPreferredPlacesPath)) {
                $this->info('Migrate user preferred areas data start');
                Excel::import(new UserPreferredAreasImport(), $userPreferredPlacesPath);
                Log::info('Migrate user preferred areas data end');
            }

            $this->info('Migrate all data end');
        } catch (\Exception $e) {
            $this->info($e->getMessage());
        }
    }
}
