<?php

namespace App\Console\Commands\MigrateData;

use App\Imports\ParticipantMainMatchImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class Participation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:participants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            $this->info('start migrate');
            $participationFirstTime = storage_path('/data-migrate/participants_first_time.csv');
            $participation = storage_path('/data-migrate/participants.csv');
            if (file_exists($participationFirstTime)) {
                Log::info('migrate participation main match from participation first time data');
                Excel::import(new ParticipantMainMatchImport(true), $participationFirstTime);
                Log::info('migrate participation main match from participation first time data success');
            }
            if (file_exists($participation)) {
                Log::info('migrate participation main match from participation data');
                Excel::import(new ParticipantMainMatchImport, $participation);
                Log::info('migrate participation main match from participation data success');
            }
            $this->info('migrate all data success');
        } catch (\Exception $e) {
            $this->info($e->getMessage());
            Log::error($e->getMessage());
        }
    }
}
