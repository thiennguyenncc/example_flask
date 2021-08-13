<?php

namespace App\Console\Commands\MigrateData;

use App\Imports\DatingImport;
use App\Imports\DatingUserCancelFormImPort;
use App\Imports\DatingUserImPort;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class Dating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:dating';

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
            $dating = storage_path('/data-migrate/dating.csv');
            $datingDetail = storage_path('/data-migrate/dating_details.csv');
            $datingCancel = storage_path('/data-migrate/request_cancellation_forms.csv');
            if (file_exists($dating)) {
                Log::info('migrate dating from current system dating table');
                Excel::import(new DatingImport, $dating);
                Log::info('migrate dating from current system dating table success');
            }
            if (file_exists($datingDetail)) {
                Log::info('migrate datingUser and dating place from current system dating_details table');
                Excel::import(new DatingUserImPort, $datingDetail);
                Log::info('migrate datingUser and dating place from current system dating_details table success');
            }
            if (file_exists($datingCancel)) {
                Log::info('migrate datingUserCancelForm from current system request_cancellation_forms table');
                Excel::import(new DatingUserCancelFormImPort(), $datingCancel);
                Log::info('migrate datingUserCancelForm from current system request_cancellation_forms table success');
            }
            $this->info('migrate all data success');
        } catch (\Exception $e) {
            $this->info($e->getMessage());
            Log::error($e->getMessage());
        }
    }
}
