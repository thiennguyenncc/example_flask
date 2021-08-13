<?php

namespace Database\Seeders;

use Bachelor\Domain\Base\Language\Enums\Languages;
use Illuminate\Database\Seeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Bachelor\Port\Secondary\Database\Base\Language\Interfaces\EloquentLanguageInterface;
use Illuminate\Support\Facades\Log;

class LanguageSeeder extends Seeder
{
    private $languageRepository;

    /**
     * LanguageSeeder constructor.
     * @throws BindingResolutionException
     */
    public function __construct ()
    {
        $this->languageRepository = app()->make(EloquentLanguageInterface::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time_start = microtime(true);
        echo 'LanguageSeeder started'. PHP_EOL;
        self::_seed();
        $time_end = microtime(true);
        Log::info('LanguageSeeder finished | took ' . ($time_end - $time_start) . 's');
    }

    /**
     *  Initiate the seeder
     */
    private function _seed()
    {
        $index = 1;
        foreach (Languages::getInstances() as $languages)
        {
            $this->languageRepository->updateOrCreate(self::_getLanguageData($index, $languages));
            $index += 1;
        }
    }

    /**
     *  Get language data
     * @param $language
     * @param $index
     * @return array
     */
    private function _getLanguageData(int $index, object $language) : array
    {
        return [
            'id' => $index,
            'name' => $language->key,
            'short_code' => $language->value
        ];
    }
}
