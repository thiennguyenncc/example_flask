<?php

namespace Database\Seeders;

use Bachelor\Domain\Base\Country\Enums\Countries;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Seeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Bachelor\Port\Secondary\Database\Base\Country\Interfaces\EloquentCountryInterface;

class CountrySeeder extends Seeder
{
    private $countryRepository;

    /**
     * LanguageSeeder constructor.
     * @throws BindingResolutionException
     */
    public function __construct ()
    {
        $this->countryRepository = app()->make(EloquentCountryInterface::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time_start = microtime(true);
        echo 'RegistrationOptionSeeder started'. PHP_EOL;
        self::_seed();
        $time_end = microtime(true);
        Log::info('RegistrationOptionSeeder finished | took ' . ($time_end - $time_start) . 's');
    }

    /**
     *  Initiate the seeder
     */
    private function _seed()
    {
        foreach (Countries::getInstances() as $country)
            $this->countryRepository->updateOrCreate($country->value);
    }
}
