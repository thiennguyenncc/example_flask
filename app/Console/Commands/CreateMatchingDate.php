<?php

namespace App\Console\Commands;

use Bachelor\Domain\DatingManagement\DatingDay\Enums\DatingDayOfWeek;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateMatchingDate extends BachelorBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datingDay:create_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private DatingDayRepositoryInterface $datingDayRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DatingDayRepositoryInterface $datingDayRepository)
    {
        $this->datingDayRepository = $datingDayRepository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param DatingDayRepositoryInterface $datingDayRepository
     *
     * @return int
     */
    public function handle()
    {
        $latestDatingDay = $this->datingDayRepository->getLatestDatingDay();
        try {
            DB::beginTransaction();
            if (!$latestDatingDay) {
                $maxWeek = config('matching.max_weeks');
                for ($i = 0; $i < $maxWeek; $i++) {
                    $date = Carbon::today()->addWeek($i);
                    $this->createDayDaysForTheWeek($date);
                }
                $this->info("create dating day data of " . $maxWeek . " week success");
            } else {
                $latestDatingDate = Carbon::parse($latestDatingDay->getDatingDate());
                $this->createDayDaysForTheWeek($latestDatingDate->addWeek(1));
                $this->info("create dating day data of one more week success");
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->info($e->getMessage());
        }
    }

    public function createDayDaysForTheWeek(Carbon $date)
    {
        $matchingDayOfWeekList = DatingDayOfWeek::getMatchingDayOfWeek();
        foreach ($matchingDayOfWeekList as $matchingDayOfWeek) {
            $date = $date->startOfWeek()->next($matchingDayOfWeek);
            $model = new DatingDay($matchingDayOfWeek, $date);
            $this->datingDayRepository->save($model);
        }
    }
}
