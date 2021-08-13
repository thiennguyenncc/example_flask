<?php

namespace Bachelor\Application\User\Providers;

use Bachelor\Application\User\Services\DatingReportService;
use Bachelor\Application\User\Services\Interfaces\DatingReportServiceInterface;
use Bachelor\Domain\FeedbackManagement\DatingReport\Interfaces\DatingReportRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\Feedback\Interfaces\FeedbackRepositoryInterface;
use Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\Repository\DatingReportRepository;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\Repository\FeedbackRepository;
use Illuminate\Support\ServiceProvider;

class FeedbackServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Application
        $this->app->bind(DatingReportServiceInterface::class, DatingReportService::class);

        // Repository
        $this->app->bind(FeedbackRepositoryInterface::class, FeedbackRepository::class);
        $this->app->bind(DatingReportRepositoryInterface::class, DatingReportRepository::class);
    }
}
