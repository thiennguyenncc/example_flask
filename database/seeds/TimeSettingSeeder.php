<?php

namespace Database\Seeders;

use Bachelor\Port\Secondary\Database\Base\TimeSetting\Interfaces\EloquentTimeSettingInterface;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Bachelor\Application\Admin\Services\Interfaces\AdminTimeSettingServiceInterface;


class TimeSettingSeeder extends Seeder
{

    /**
     * @var EloquentTimeSettingInterface
     */
    private $timeSettingRepository;

    /**
     *
     * @var AdminTimeSettingServiceInterface
     */
    private $timeSettingService;

    /**
     * Time setting seeder constructor
     */
    public function __construct()
    {
        $this->timeSettingRepository = app()->make(EloquentTimeSettingInterface::class);
        $this->timeSettingService = app()->make(AdminTimeSettingServiceInterface::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeSettings = $this->timeSettingRepository->getModel()->get();

        if ($timeSettings->isEmpty()) {

            $params['starts_at'] = Carbon::now()->startOfWeek();
            $params['cycle'] = config('timings.cycles.1_week');

            $this->timeSettingService->createNewCycle($params);
        }
    }
}
