<?php

namespace App\Console\Commands;

use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CompleteDating extends BachelorBaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complete:dating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete dating';

    private DatingDayRepositoryInterface $datingDayRepository;

    private DatingRepositoryInterface $datingRepository;

    public function __construct(DatingDayRepositoryInterface $datingDayRepository, DatingRepositoryInterface $datingRepository)
    {
        parent::__construct();

        $this->datingDayRepository = $datingDayRepository;

        $this->datingRepository = $datingRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get dating day
        $datingDay = $this->datingDayRepository->getByDate(Carbon::now()->toDateString());

        if (!$datingDay) {
            $this->info('Failed to complete dating');
            return;
        }
        $datings = $this->datingRepository->getIncompletedDatingsByDatingDay($datingDay->getId());
        
        $datings->each(function (Dating $dating) {
            try {
                $dating->complete();
                $this->datingRepository->save($dating);
                Log::channel('dating')->info('Completed Dating', [
                    'dating_day_id' => $dating->getDatingDay()->getId(),
                    'dating_id' => $dating->getId()
                ]);
            } catch (\Throwable $th) {
                Log::error($th, [
                    'dating_day_id' => $dating->getDatingDay()->getId(),
                    'dating_id' => $dating->getId()
                ]);
            }
        });

        $this->info('Completed dating successfully');
        return;
    }
}
