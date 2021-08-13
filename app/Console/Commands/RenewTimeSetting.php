<?php
namespace App\Console\Commands;

use Bachelor\Domain\Base\TimeSetting\Services\TimeSettingService;

class RenewTimeSetting extends BachelorBaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renew:time_setting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates time settings table for upcoming week';

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
     * @param TimeSettingService $timeSettingService
     */
    public function handle(TimeSettingService $timeSettingService)
    {

        $timeSettingService->renewTimeCycle();

        $this->info('done');
    }
}
