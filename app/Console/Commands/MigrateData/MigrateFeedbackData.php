<?php

namespace App\Console\Commands\MigrateData;

use App\Console\Commands\BachelorBaseCommand;
use App\Imports\Feedback\FeedbackImport;
use App\Imports\Feedback\ReviewBoxImport;
use App\Imports\Feedback\ReviewPointImport;
use App\Imports\Feedback\StarCategoryImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MigrateFeedbackData extends BachelorBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:feedback-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate feedback data from old database';

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
            $this->info('Start migrate');
            $reviewBoxesPath = storage_path('/data-migrate/review_boxes.csv');
            $reviewPointsPath = storage_path('/data-migrate/review_points.csv');
            $starCategoriesPath = storage_path('/data-migrate/star_categories.csv');
            $feedbackPath = storage_path('/data-migrate/reviews.json');

            if (file_exists($reviewPointsPath)) {
                $this->info('Migrate review points data start');
                Excel::import(new ReviewPointImport(), $reviewPointsPath);
                Log::info('Migrate review points data end');
            }
            if (file_exists($starCategoriesPath)) {
                $this->info('Migrate star categories data start');
                Excel::import(new StarCategoryImport(), $starCategoriesPath);
                Log::info('Migrate star categories data end');
            }
            if (file_exists($reviewBoxesPath)) {
                $this->info('Migrate review boxes data start');

                Excel::import(new ReviewBoxImport(), $reviewBoxesPath);
                Log::info('Migrate review boxes data end');
            }
            if (file_exists($feedbackPath)) {
                $this->info('Migrate feedbacks data start');
                $dataJson = file_get_contents($feedbackPath);
                $reviewsData = json_decode($dataJson, true);
                $reviews = [];
                if (isset($reviewsData['reviews'])) {
                    $reviews = $reviewsData['reviews'];
                }
                (new FeedbackImport($reviews))->handle();
                Log::info('Migrate feedbacks data end');
            }
            $this->info('Migrate all data end');

        } catch (\Exception $exception) {
            $this->info($exception->getMessage());
        }
    }
}
