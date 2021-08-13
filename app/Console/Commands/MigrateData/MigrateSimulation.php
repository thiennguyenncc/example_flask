<?php

namespace App\Console\Commands\MigrateData;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateSimulation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:simulation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulation for data migration';

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
        DB::beginTransaction();
        try {
            $this->info('Start simulation');
            $this->call(MigrateAdminData::class);
            $this->call(MigratePrefectureData::class);
            $this->call(MigrateAuthenticationData::class);
            $this->call(MigrateUserProfileData::class);
            $this->call(MigrateUserPreferenceData::class);
            $this->call(MigrateUserPreferredAreasData::class);
            $this->call(DatingDay::class);
            $this->call(Participation::class);
            $this->call(Dating::class);
            $this->call(MigrateChatData::class);
            $this->call(MigrateFeedbackData::class);
            $this->call(MigrateDatingReportData::class);
            $this->info('Finish simulation');
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->info($exception->getMessage());
        }

    }
}
