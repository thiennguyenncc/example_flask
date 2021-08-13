<?php

namespace App\Console\Commands\MigrateData;

use App\Imports\User\UserProfileImport;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class MigrateUserProfileData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:user-profile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate user profile data from old system';

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
            $userProfilePath = storage_path('/data-migrate/user_profile.csv');

            if (file_exists($userProfilePath)) {
                $this->info('Migrate user profile data start');
                Excel::import(new UserProfileImport(), $userProfilePath);
                Log::info('Migrate user profile data end');
            }
            $this->info('Migrate all data end');

        } catch (\Exception $exception) {
            $this->info($exception->getMessage());
        }
    }
}
