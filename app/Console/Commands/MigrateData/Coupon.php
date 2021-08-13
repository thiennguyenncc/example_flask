<?php

namespace App\Console\Commands\MigrateData;

use App\Imports\UserCouponImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Coupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:coupon';

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
            $userCoupons = storage_path('/data-migrate/user_coupons.csv');
            if (file_exists($userCoupons)) {
                $this->info('migrate coupons from current system user_coupons table');
                (new UserCouponImport())->withOutput($this->output)->import($userCoupons);
                $this->info('migrate coupons from current system user_coupons table success');
            }
            $this->info('migrate all data success');
        } catch (\Exception $e) {
            $this->info($e->getMessage());
            Log::error($e->getMessage());
        }
    }
}
