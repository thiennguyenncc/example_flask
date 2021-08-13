<?php

namespace App\Console\Commands;

use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Carbon\Carbon;
use Bachelor\Application\User\Services\DatingApplicationService;

class CancelFakeDating extends BachelorBaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:fake_dating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel dating of male users who were matched with fake female users';

    private DatingDayRepositoryInterface $datingDayRepository;

    private DatingApplicationService $datingService;

    public function __construct(DatingDayRepositoryInterface $datingDayRepository, DatingApplicationService $datingService)
    {
        parent::__construct();

        $this->datingDayRepository = $datingDayRepository;

        $this->datingService = $datingService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get dating day for which to cancel dating
        $datingDay = $this->datingDayRepository->getByDate(Carbon::tomorrow()->toDateString());

        if (!empty($datingDay)) {
            $this->datingService->cancelAllFakeDatings($datingDay->getId());
        }

        return 0;
    }
}
