<?php

namespace Database\Seeders;

use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationOptions;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Illuminate\Database\Seeder;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Contracts\Container\BindingResolutionException;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\ModelDao\RegisterOption;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Interfaces\EloquentRegisterOptionInterface;

class RegistrationOptionSeeder extends Seeder
{
    private $registrationOptionRepository;

    /**
     * RegistrationOptionSeeder constructor.
     * @throws BindingResolutionException
     */
    public function __construct ()
    {
        $this->registrationOptionRepository = app()->make(EloquentRegisterOptionInterface::class);
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
        // Loop over each gender data
        foreach (RegistrationOptions::getInstances() as $genderBasedRegistrationOptions)
            // Loop over each option in gender data
            foreach ($genderBasedRegistrationOptions->value as $gender => $registrationOptions)
                // Loop over each registration option
                foreach ($registrationOptions as $registrationOption)
                    self::_createRegisterOption($genderBasedRegistrationOptions, $gender, $registrationOption);
    }

    /**
     *  Get all registration options data
     *
     * @param $key
     * @param $gender
     * @param $registrationOption
     * @return array
     */
    private static function _getRegistrationOptionData(string $key, string $gender, array $registrationOption) : array
    {
        return [
            'allowed_gender' => $gender === 'neutral' ? null : UserGender::getValue($gender),
            'option_value' => $registrationOption['value'],
            'option_key' => "$key-".strtolower($gender)."-".$registrationOption['value'],
            'status' => $registrationOption['status'],
            'type' => $key,
            'sort' => $registrationOption['sort']
        ];
    }

    /**
     * Create all registration options
     *
     * @param $genderBasedRegistrationOptions
     * @param $gender
     * @param $registrationOption
     */
    private function _createRegisterOption(object $genderBasedRegistrationOptions,string $gender,array $registrationOption)
    {
        $registerOption = $this->registrationOptionRepository->updateOrCreate( self::_getRegistrationOptionData(
            $genderBasedRegistrationOptions->key ,
            $gender,
            $registrationOption
        ));
        self::_createRegistrationOptionTranslation($registerOption, $registrationOption);
    }

    /**
     * Get all registration options translation data
     *
     * @param $registrationOptionLanguage
     * @param $languageId
     * @return array
     */
    private static function _getRegistrationOptionTranslationData(array $registrationOptionLanguage,int $languageId) : array
    {
        return [
            'label_name' => $registrationOptionLanguage['label_name'],
            'display_name' => $registrationOptionLanguage['display_name'],
            'language_id' => $languageId
        ];
    }

    /**
     * Create new registration option translation record
     *
     * @param RegisterOption $registerOption
     * @param array $registrationOption
     */
    private function _createRegistrationOptionTranslation(RegisterOption $registerOption, array $registrationOption)
    {
        $translationCount = count($registrationOption['register_options_translations']);
        for ( $index = 0; $index < $translationCount; $index++ )
        {
            $this->registrationOptionRepository->updateOrCreateRegisterOptionTranslation(
                $registerOption ,
                self::_getRegistrationOptionTranslationData(
                    $registrationOption['register_options_translations'][$index] ,
                    $index + 1
                )
            );
        }
    }
}
