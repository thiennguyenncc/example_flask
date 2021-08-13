<?php

namespace App\Console\Commands\MigrateData;

use App\Console\Commands\BachelorBaseCommand;
use App\Imports\DatingReport\DatingReportImport;
use Bachelor\Utility\Helpers\Log;
use Maatwebsite\Excel\Facades\Excel;

class MigrateDatingReportData extends BachelorBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:dating-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate dating report from old data';

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
     */
    public function handle()
    {
        try {
            $this->info('Start migrate');
            $datingReportPath = storage_path('/data-migrate/dating_reports.json');

            if (file_exists($datingReportPath)) {
                $this->info('Migrate dating report data start');
                $dataJson = file_get_contents($datingReportPath);
                $datingReportData = json_decode($dataJson, true);
                $datingReports = [];
                if (isset($datingReportData['dating_report_histories'])) {
                    $datingReports = $datingReportData['dating_report_histories'];
                }
                (new DatingReportImport($datingReports))->handle();
                Log::info('Migrate dating report data end');
            }
            $this->info('Migrate all data end');

        } catch (\Exception $exception) {
            $this->info($exception->getMessage());
        }
    }
}
