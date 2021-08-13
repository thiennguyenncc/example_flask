<?php

namespace Database\Seeders;

use Bachelor\Domain\Base\Admin\Enums\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Bachelor\Port\Secondary\Database\Base\Admin\Interfaces\EloquentAdminInterface;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
{
    private $adminRepository;

    /**
     * RegistrationOptionSeeder constructor.
     * @throws BindingResolutionException
     */
    public function __construct ()
    {
        $this->adminRepository = app()->make(EloquentAdminInterface::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time_start = microtime(true);
        echo 'AdminSeeder started'. PHP_EOL;
        self::_seed();
        $time_end = microtime(true);
        Log::info('AdminSeeder finished | took ' . ($time_end - $time_start) . 's'.PHP_EOL);
    }

    /**
     *  Initiate the seeder
     */
    private function _seed()
    {
        // Loop over admin list
        foreach (Admin::getInstances() as $admin)
            $this->adminRepository->updateOrCreate($admin->value);
    }


}
