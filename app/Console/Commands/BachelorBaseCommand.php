<?php
namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

abstract Class BachelorBaseCommand extends Command
{
    /**
     * BachelorBaseCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (env('APP_ENV') != 'production' && env('FAKE_CURRENT_TIME')) {
            Carbon::setTestNow(env('FAKE_CURRENT_TIME'));
        }
    }
}
