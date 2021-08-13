<?php

namespace App\Console\Commands\MigrateData;

use App\Imports\User\UserPreferenceImport;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class MigrateUserPreferenceData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:user-preference';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate user preference table from old system to new system';

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
            $this->info('Start migrate');
            $userPreferencePath = storage_path('/data-migrate/user_preferences.csv');

            if (file_exists($userPreferencePath)) {
                $this->info('Migrate user preference data start');
                Excel::import(new UserPreferenceImport(), $userPreferencePath);
                Log::info('Migrate user preference data end');
            }
            $this->info('Migrate all data end');

        } catch (\Exception $exception) {
            $this->info($exception->getMessage());
        }
    }
}
