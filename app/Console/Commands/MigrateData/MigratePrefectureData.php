<?php

namespace App\Console\Commands\MigrateData;

use App\Console\Commands\BachelorBaseCommand;
use App\Imports\Prefecture\AreaImport;
use App\Imports\Prefecture\AreaTranslationImport;
use App\Imports\Prefecture\DatingPlaceImport;
use App\Imports\Prefecture\DatingPlaceTranslationImport;
use App\Imports\Prefecture\PrefectureImport;
use App\Imports\Prefecture\PrefectureTranslationImport;
use App\Imports\Prefecture\TrainStationImport;
use App\Imports\Prefecture\TrainStationTranslationImport;
use App\Imports\Prefecture\UserPreferredAreasImport;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MigratePrefectureData extends BachelorBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:prefecture';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from old data';

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
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $this->info('Start migrate');
            $prefecturePath = storage_path('/data-migrate/prefectures.csv');
            $prefectureTranslationPath = storage_path('/data-migrate/prefecture_language.csv');
            $areaPath = storage_path('/data-migrate/area.csv');
            $areaTranslationPath = storage_path('/data-migrate/area_language.csv');
            $datingPlacePath = storage_path('/data-migrate/locations.csv');
            $datingPlaceTranslationPath = storage_path('/data-migrate/location_language.csv');
            $trainStationPath = storage_path('/data-migrate/train_station.csv');
            $trainStationTranslationPath = storage_path('/data-migrate/train_station_language.csv');

            if (file_exists($prefecturePath)) {
                $this->info('Migrate prefecture data start');
                Excel::import(new PrefectureImport(), $prefecturePath);
                Log::info('Migrate prefecture data end');
            }
            if (file_exists($prefectureTranslationPath)) {
                $this->info('Migrate prefecture translation data start');
                Excel::import(new PrefectureTranslationImport(), $prefectureTranslationPath);
                Log::info('Migrate prefecture translation data end');
            }
            if (file_exists($areaPath)) {
                $this->info('Migrate area data start');
                Excel::import(new AreaImport(), $areaPath);
                Log::info('Migrate area data end');
            }

            if (file_exists($areaTranslationPath)) {
                $this->info('Migrate area translation data start');
                Excel::import(new AreaTranslationImport(), $areaTranslationPath);
                Log::info('Migrate area translation data end');
            }
            if (file_exists($datingPlacePath)) {
                $this->info('Migrate dating place data start');
                Excel::import(new DatingPlaceImport(), $datingPlacePath);
                Log::info('Migrate dating place data end');
            }
            if (file_exists($datingPlaceTranslationPath)) {
                $this->info('Migrate dating place translation data start');
                Excel::import(new DatingPlaceTranslationImport(), $datingPlaceTranslationPath);
                Log::info('Migrate dating place translation data end');
            }
            if (file_exists($trainStationPath)) {
                $this->info('Migrate train station data start');
                Excel::import(new TrainStationImport(), $trainStationPath);
                Log::info('Migrate train station data end');
            }

            if (file_exists($trainStationTranslationPath)) {
                $this->info('Migrate train station translation data start');
                Excel::import(new TrainStationTranslationImport(), $trainStationTranslationPath);
                Log::info('Migrate train station translation data end');
            }
            $this->info('Migrate all data end');
            DB::commit();
        } catch (\Exception $exception) {
            $this->info($exception->getMessage());
            DB::rollBack();
        }
    }
}
