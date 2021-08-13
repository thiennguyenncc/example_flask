<?php
$minute = 60;
$hour = $minute * 60;
$day = $hour * 24;
return [

    /*
     * List of timings that we use in the system for
     * cronjobs, web app time validations
     * The system will allocate the keys in given cycle
     *
     * Note: Only create new key if day and time does not exist
     */

    'day_time' => [
        'monday_0' => 0,
        'monday_10' => 10 * $hour,
        'monday_12' => 12 * $hour,
        'monday_15' => 15 * $hour,
        'monday_20' => 20 * $hour,
        'monday_23_59_59' => 23 * $hour + 59 * $minute + 59,
        'tuesday_0' => $day,
        'tuesday_5' => $day + 5 * $hour,
        'tuesday_9' => $day + 9 * $hour,
        'tuesday_12' => $day + 12 * $hour,
        'tuesday_13' => $day + 13 * $hour,
        'tuesday_15' => $day + 15 * $hour,
        'tuesday_20' => $day + 20 * $hour,
        'tuesday_21' => $day + 21 * $hour,
        'wednesday_0' => 2 * $day,
        'wednesday_5' => 2 * $day + 5 * $hour,
        'wednesday_12' => 2 * $day + 12 * $hour,
        'wednesday_13' => 2 * $day + 13 * $hour,
        'wednesday_15' => 2 * $day + 15 * $hour,
        'wednesday_18' => 2 * $day + 18 * $hour,
        'wednesday_20' => 2 * $day + 20 * $hour,
        'thursday_0' => 3 * $day,
        'thursday_5' => 3 * $day + 5 * $hour,
        'thursday_9' => 3 * $day + 9 * $hour,
        'thursday_12' => 3 * $day + 12 * $hour,
        'friday_0' => 4 * $day,
        'friday_5' => 4 * $day + 5 * $hour,
        'friday_9' => 4 * $day + 9 * $hour,
        'friday_13' => 4 * $day + 13 * $hour,
        'friday_15' => 4 * $day + 15 * $hour,
        'friday_20' => 4 * $day + 20 * $hour,
        'saturday_0' => 5 * $day,
        'saturday_5' => 5 * $day + 5 * $hour,
        'saturday_9' => 5 * $day + 9 * $hour,
        'saturday_12' => 5 * $day + 12 * $hour,
        'saturday_13' => 5 * $day + 13 * $hour,
        'saturday_15' => 5 * $day + 15 * $hour,
        'saturday_12_30' => 5 * $day + 12 * $hour + 30 * $minute,
        'saturday_20' => 5 * $day + 20 * $hour,
        'sunday_0' => 6 * $day,
        'sunday_5' => 6 * $day + 5 * $hour,
        'sunday_9' => 6 * $day + 9 * $hour,
        'sunday_12' => 6 * $day + 12 * $hour,
        'sunday_12_30' => 6 * $day + 12 * $hour + 30 * $minute,
        'sunday_21' => 6 * $day + 21 * $hour,
        'sunday_13' => 6 * $day + 13 * $hour + 30 * $minute,
        'sunday_15' => 6 * $day + 15 * $hour + 30 * $minute,
        'sunday_23_59_59' => 6 * $day + 23 * $hour + 59 * $minute + 59,
        'next_sunday_23_59_59' => 0,
        'next_next_saturday_0' => 0,
        'next_next_saturday_23_59_59' => 0,
        'next_next_sunday_0' => 0,
        'next_next_sunday_23_59_59' => 0
    ],

    /*
     * Should map to day_time
     * For reusability
     */
    'keys' => [
        'monday_complete_trial' => 'monday_0',
        'week_start' => 'monday_0',
        'week_end' => 'sunday_23_59_59',
        'tuesday_complete_trial' => 'tuesday_0',
        'wednesday_complete_trial' => 'wednesday_0',
        'thursday_complete_trial' => 'thursday_0',
        'wednesday_main_matching' => 'tuesday_5', // 1 day before
        'wednesday_12pm_matching' => 'wednesday_12',
        'friday_complete_trial' => 'friday_0',
        'saturday_complete_trial' => 'saturday_0',
        'saturday_main_matching' => 'friday_5',
        'saturday_12pm_rematching' => 'saturday_12',
        'sunday_complete_trial' => 'sunday_0',
        'sunday_main_matching' => 'saturday_5',
        'sunday_12pm_rematching' => 'sunday_12',
        'renew_cycle' => 'sunday_23_59_59',
        'monday_grace_period_check' => 'monday_0',
        'tuesday_grace_period_check' => 'tuesday_0',
        'wednesday_grace_period_check' => 'wednesday_0',
        'thursday_grace_period_check' => 'thursday_0',
        'friday_grace_period_check' => 'friday_0',
        'saturday_grace_period_check' => 'saturday_0',
        'sunday_grace_period_check' => 'sunday_0',
    ],

    /*
     * Map cron_jobs with timing key
     */
    'cron_jobs' => [
        'monday_complete_trial' => '',
        'wednesday_main_matching' => '',
        'wednesday_12pm_matching' => '',
        'thursday_complete_trial' => '',
        'saturday_main_matching' => '',
        'saturday_12pm_rematching' => '',
        'sunday_complete_trial' => '',
        'sunday_main_matching' => '',
        'sunday_12pm_rematching' => '',
        'renew_cycle' => 'renew:time_setting',
        'monday_grace_period_check' => 'check:grace_period_expired',
        'tuesday_grace_period_check' => 'check:grace_period_expired',
        'wednesday_grace_period_check' => 'check:grace_period_expired',
        'thursday_grace_period_check' => 'check:grace_period_expired',
        'friday_grace_period_check' => 'check:grace_period_expired',
        'saturday_grace_period_check' => 'check:grace_period_expired',
        'sunday_grace_period_check' => 'check:grace_period_expired',
    ],

    /*
     * Time cycles in the system
     */
    'cycles' => [
        '1_week' => '1_week',
        '1_hour' => '1_hour',
        '12_hour' => '12_hour',
        '15_minute' => '15_minute'
    ],

    /*
     * You do not need to change this
     */
    'second_config' => [
        'seconds_in_10_minute' => 60 * 10,
        'seconds_in_15_minute' => 60 * 16,
        'seconds_in_1_hour' => 60 * 60 * 1,
        'seconds_in_12_hours' => 60 * 60 * 12,
        'seconds_in_1_week' => 60 * 60 * 24 * 7
    ]
];
