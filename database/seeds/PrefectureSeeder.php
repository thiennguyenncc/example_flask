<?php

namespace Database\Seeders;

use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Seeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Bachelor\Domain\MasterDataManagement\Prefecture\Enums\Prefecture;
use Bachelor\Domain\MasterDataManagement\Prefecture\Interfaces\PrefectureRepositoryInterface;

class PrefectureSeeder extends Seeder
{
    private $prefectureRepository;

    /**
     * RegistrationOptionSeeder constructor.
     * @throws BindingResolutionException
     */
    public function __construct ()
    {
        $this->prefectureRepository = app()->make(PrefectureRepositoryInterface::class);
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
        // Loop over admin list
        foreach (Prefecture::getInstances() as $prefecture)
            self::_updateOrCreatePrefecture($prefecture);
    }

    /**
     *  Update or create new prefecture
     * @param $prefectureData
     */
    private function _updateOrCreatePrefecture($prefectureData)
    {
        $prefecture = $this->prefectureRepository->updateOrCreate(self::_getPrefectureData($prefectureData));
        
        foreach ($prefectureData->value['prefecture_translations'] as $key => $translation)
            $this->prefectureRepository->updateOrCreatePrefectureTranslation($prefecture->toDomainEntity(), self::_getPrefectureTranslation($translation, (int) $key + 1));
    }

    /**
     *  Get prefecture data
     * @param $prefecture
     * @return array
     */
    private function _getPrefectureData(object $prefecture) : array
    {
        return [
            'name' => $prefecture->value['name'],
            'country_id' => $prefecture->value['country'],
            'admin_id' => $prefecture->value['admin'],
            'status' => $prefecture->value['status']
        ];
    }

    /**
     *  Get prefecture translation data
     * @param string $name
     * @param int $language_id
     * @return array
     */
    private function _getPrefectureTranslation(string $name, int $language_id) : array
    {
        return [
            'language_id' => $language_id,
            'name' => $name
        ];
    }
}
