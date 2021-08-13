<?php

namespace Database\Seeders;

use Bachelor\Domain\Base\Currency\Enums\Currencies;
use Illuminate\Database\Seeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Bachelor\Port\Secondary\Database\Base\Currency\Interfaces\EloquentCurrencyInterface;
use Illuminate\Support\Facades\Log;

class CurrencySeeder extends Seeder
{
    private $currencyRepository;

    /**
     * RegistrationOptionSeeder constructor.
     * @throws BindingResolutionException
     */
    public function __construct ()
    {
        $this->currencyRepository = app()->make(EloquentCurrencyInterface::class);
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
        Log::info('RegistrationOptionSeeder finished | took ' . ($time_end - $time_start) . 's'.PHP_EOL);

    }

    /**
     *  Initiate the seeder
     */
    private function _seed()
    {
        foreach (Currencies::getInstances() as $currency)
            $this->currencyRepository->updateOrCreate(self::_getCurrencyData($currency));
    }

    /**
     * Get data related to currency table
     *
     * @param $currency
     * @return array
     */
    private function _getCurrencyData($currency)
    {
        return [
            'name' => $currency->key,
            'short_code' => $currency->value
        ];
    }
}
