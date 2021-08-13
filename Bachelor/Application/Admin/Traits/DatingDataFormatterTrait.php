<?php

namespace Bachelor\Application\Admin\Traits;

use Bachelor\Domain\DatingManagement\DatingDay\Enums\DatingDayOfWeek;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\Dating;

trait DatingDataFormatterTrait
{
    /**
     * Get formatted data to store dating
     *
     * @param Dating $dating
     * @param array $params
     * @return array
     */
    public function getFormattedDataForDating(array $params) : array
    {
        $maleUserPreferredPlaces = [];
        $feMaleUserPreferredPlaces = [];
        if (!empty($params['maleUserPreferredPlaces'])){
            foreach ($params['maleUserPreferredPlaces'] as $p){
                if (!empty($p)){
                    $maleUserPreferredPlaces[] = $p['area_id'];
                }
            }
        }
        if (!empty($params['femaleUserPreferredPlaces'])){
            foreach ($params['femaleUserPreferredPlaces'] as $p){
                if (!empty($p)){
                    $feMaleUserPreferredPlaces[] = $p['area_id'];
                }
            }
        }
        return [
            'dating' => [
                'dating_day_id' => $params['dating_day_id'],
                'start_at' => $params['time'],
                'dating_place_id' => $params['dating_place_id'],
            ],
            'datingMaleUser' => [
                'user_id' => $params['male'],
            ],
            'datingFemaleUser' => [
                'user_id' => $params['female'],
            ]
        ];
    }
    /**
     * format request data to single day infomation
     *
     * @param array $params
     * @return array
     */
    public function getConvertMigrateDatingDayOfWeekData($params) : array
    {
        return [
            'Wednesday' => [
                'secondFormCompleted' => [
                    'user_gender' => $params['userGender'],
                    'dating_day_of_week' => DatingDayOfWeek::Wednesday,
                    'is_user_2nd_form_completed' =>  1,
                    'open_days_before_dating_date' =>  $params['wednesdaySecondFormCompletedOpenDay'],
                    'expiry_days_before_dating_date' =>  $params['wednesdaySecondFormCompletedExpireDay']
                ],
                'secondFormInCompleted' => [
                    'user_gender' => $params['userGender'],
                    'dating_day_of_week' => DatingDayOfWeek::Wednesday,
                    'is_user_2nd_form_completed' =>  0,
                    'open_days_before_dating_date' =>  $params['wednesdaySecondFormInCompletedOpenDay'],
                    'expiry_days_before_dating_date' =>  $params['wednesdaySecondFormInCompletedExpireDay']
                ],
            ],
            'Saturday' => [
                'secondFormCompleted' => [
                    'user_gender' => $params['userGender'],
                    'dating_day_of_week' => DatingDayOfWeek::Saturday,
                    'is_user_2nd_form_completed' =>  1,
                    'open_days_before_dating_date' =>  $params['saturdaySecondFormCompletedOpenDay'],
                    'expiry_days_before_dating_date' =>  $params['saturdaySecondFormCompletedExpireDay']
                ],
                'secondFormInCompleted' => [
                    'user_gender' => $params['userGender'],
                    'dating_day_of_week' => DatingDayOfWeek::Saturday,
                    'is_user_2nd_form_completed' =>  0,
                    'open_days_before_dating_date' =>  $params['saturdaySecondFormInCompletedOpenDay'],
                    'expiry_days_before_dating_date' =>  $params['saturdaySecondFormInCompletedExpireDay']
                ],
            ],
            'Sunday' => [
                'secondFormCompleted' => [
                    'user_gender' => $params['userGender'],
                    'dating_day_of_week' => DatingDayOfWeek::Sunday,
                    'is_user_2nd_form_completed' =>  1,
                    'open_days_before_dating_date' =>  $params['sundaySecondFormCompletedOpenDay'],
                    'expiry_days_before_dating_date' =>  $params['sundaySecondFormCompletedExpireDay']
                ],
                'secondFormInCompleted' => [
                    'user_gender' => $params['userGender'],
                    'dating_day_of_week' => DatingDayOfWeek::Sunday,
                    'is_user_2nd_form_completed' =>  0,
                    'open_days_before_dating_date' =>  $params['sundaySecondFormInCompletedOpenDay'],
                    'expiry_days_before_dating_date' =>  $params['sundaySecondFormInCompletedExpireDay']
                ],
            ],
        ];
    }
}
