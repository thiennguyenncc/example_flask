<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bachelor\Port\Secondary\Database\DatingManagement\Matching\Interfaces\EloquentMatchingSettingInterface;
use Bachelor\Domain\DatingManagement\Matching\Enums\MatchingSettingCategory;
use Bachelor\Domain\DatingManagement\Matching\Enums\MatchingSettingType;

class MatchingSettingTableSeeder extends Seeder
{

    private $matchingSettingRepository;

    /**
     * MatchingSettingTableSeeder constructor.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->matchingSettingRepository = app()->make(EloquentMatchingSettingInterface::class);
    }

    /**
     * Get priority point settings
     *
     * @return array
     */
    protected function getPriorityPointSettings()
    {
        return [
            [
                'setting_key' => 'feedback_count_min',
                'value' => 3,
                'category' => MatchingSettingCategory::General
            ],
            [
                'setting_key' => 'team_member_rate_min',
                'value' => 3,
                'category' => MatchingSettingCategory::TeamMemberRating
            ],
            [
                'setting_key' => 'team_member_rate_max',
                'value' => 8,
                'category' => MatchingSettingCategory::TeamMemberRating
            ],
            [
                'setting_key' => 'starting_male_face_multiple',
                'value' => 3,
                'category' => MatchingSettingCategory::StartingPoint
            ],
            [
                'setting_key' => 'starting_female_face_multiple',
                'value' => 10,
                'category' => MatchingSettingCategory::StartingPoint
            ],
            [
                'setting_key' => 'starting_point_min_no_feedback',
                'value' => 3,
                'category' => MatchingSettingCategory::StartingPoint
            ],
            [
                'setting_key' => 'starting_point_min_limit',
                'value' => 3,
                'category' => MatchingSettingCategory::StartingPoint
            ],
            [
                'setting_key' => 'starting_point_max_limit',
                'value' => 8,
                'category' => MatchingSettingCategory::StartingPoint
            ],
            [
                'setting_key' => 'starting_point_male_face_multiple',
                'value' => 3,
                'category' => MatchingSettingCategory::StartingPoint
            ],
            [
                'setting_key' => 'starting_point_female_face_multiple',
                'value' => 10,
                'category' => MatchingSettingCategory::StartingPoint
            ],
            [
                'setting_key' => 'starting_point_male_personality_multiple',
                'value' => 6,
                'category' => MatchingSettingCategory::StartingPoint
            ],
            [
                'setting_key' => 'starting_point_female_personality_multiple',
                'value' => 5,
                'category' => MatchingSettingCategory::StartingPoint
            ],
            [
                'setting_key' => 'plan_point_light_plan',
                'value' => 0,
                'category' => MatchingSettingCategory::PlanPoint
            ],
            [
                'setting_key' => 'plan_point_normal_plan',
                'value' => 300,
                'category' => MatchingSettingCategory::PlanPoint
            ],
            [
                'setting_key' => 'plan_point_premium_plan',
                'value' => 450,
                'category' => MatchingSettingCategory::PlanPoint
            ],
            [
                'setting_key' => 'review_point_lower_limit',
                'value' => 106,
                'category' => MatchingSettingCategory::ReviewPoint
            ],
            [
                'setting_key' => 'review_point_incline_number',
                'value' => 15,
                'category' => MatchingSettingCategory::ReviewPoint
            ],
            [
                'setting_key' => 'male_review_multiple',
                'value' => 1,
                'category' => MatchingSettingCategory::ReviewPoint
            ],
            [
                'setting_key' => 'female_review_multiple',
                'value' => 15,
                'category' => MatchingSettingCategory::ReviewPoint
            ],
            [
                'setting_key' => 'timing_point_trial_male_first_date',
                'value' => 1000,
                'category' => MatchingSettingCategory::TimingPoint
            ],
            [
                'setting_key' => 'timing_point_trial_male_not_first_date',
                'value' => 1000,
                'category' => MatchingSettingCategory::TimingPoint
            ],
            [
                'setting_key' => 'timing_point_paid_male_first_date_in_subscription_month',
                'value' => 2100,
                'category' => MatchingSettingCategory::TimingPoint
            ],
            [
                'setting_key' => 'timing_point_paid_male_not_first_date_in_subscription_month',
                'value' => 0,
                'category' => MatchingSettingCategory::TimingPoint
            ],
            [
                'setting_key' => 'timing_point_female_first_date',
                'value' => 2500,
                'category' => MatchingSettingCategory::TimingPoint
            ],
            [
                'setting_key' => 'timing_point_female_not_first_date',
                'value' => 0,
                'category' => MatchingSettingCategory::TimingPoint
            ],

            [
                'setting_key' => 'last_satisfaction_user_no_participation',
                'value' => 0,
                'category' => MatchingSettingCategory::LastSatisfaction
            ],
            [
                'setting_key' => 'last_satisfaction_unmatched',
                'value' => 1,
                'category' => MatchingSettingCategory::LastSatisfaction
            ],
            [
                'setting_key' => 'last_satisfaction_matched_no_review',
                'value' => 3,
                'category' => MatchingSettingCategory::LastSatisfaction
            ],
            [
                'setting_key' => 'last_satisfaction_date_cancelled',
                'value' => 1,
                'category' => MatchingSettingCategory::LastSatisfaction
            ],
            [
                'setting_key' => 'last_satisfaction_female_bachelor_coupon',
                'value' => 1,
                'category' => MatchingSettingCategory::LastSatisfaction
            ],

            [
                'setting_key' => 'male_last_satisfaction_converted_zero',
                'value' => 0,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],
            [
                'setting_key' => 'male_last_satisfaction_converted_one',
                'value' => 1400,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],
            [
                'setting_key' => 'male_last_satisfaction_converted_two',
                'value' => 300,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],
            [
                'setting_key' => 'male_last_satisfaction_converted_three',
                'value' => -500,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],
            [
                'setting_key' => 'male_last_satisfaction_converted_four',
                'value' => -800,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],
            [
                'setting_key' => 'male_last_satisfaction_converted_five',
                'value' => -1000,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],

            [
                'setting_key' => 'female_last_satisfaction_converted_zero',
                'value' => 0,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],
            [
                'setting_key' => 'female_last_satisfaction_converted_one',
                'value' => 3000,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],
            [
                'setting_key' => 'female_last_satisfaction_converted_two',
                'value' => 1500,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],
            [
                'setting_key' => 'female_last_satisfaction_converted_three',
                'value' => -3500,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],
            [
                'setting_key' => 'female_last_satisfaction_converted_four',
                'value' => -4500,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],
            [
                'setting_key' => 'female_last_satisfaction_converted_five',
                'value' => -5000,
                'category' => MatchingSettingCategory::LastSatisfactionConverted
            ],
            [
                'setting_key' => 'male_bachelor_coupon_point',
                'value' => 8000,
                'category' => MatchingSettingCategory::BachelorCouponPoint
            ],

            [
                'setting_key' => 'male_specific_addon_multiple',
                'value' => 6,
                'category' => MatchingSettingCategory::SpecificAddonPoint
            ]
        ];
    }

    protected function getOverallPointSettings()
    {
        return [
            [
                'setting_key' => 'starting_female_face_multiple_appearance_more_important',
                'value' => 11.25,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],
            [
                'setting_key' => 'starting_female_face_multiple_appearance_little_important',
                'value' => 10,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],
            [
                'setting_key' => 'starting_female_personality_multiple_appearance_more_important',
                'value' => 3.75,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],
            [
                'setting_key' => 'starting_female_personality_multiple_appearance_little_important',
                'value' => 5,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],
            [
                'setting_key' => 'starting_female_face_multiple_overall_point',
                'value' => 7.5,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],
            [
                'setting_key' => 'starting_female_personality_multiple_overall_point',
                'value' => 7.5,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],
            [
                'setting_key' => 'starting_male_face_multiple_appearance_more_important',
                'value' => 7,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],
            [
                'setting_key' => 'starting_male_face_multiple_appearance_little_important',
                'value' => 5,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],
            [
                'setting_key' => 'starting_male_face_multiple_overall_point',
                'value' => 3,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],
            [
                'setting_key' => 'starting_male_personality_multiple_appearance_more_important',
                'value' => 4,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],
            [
                'setting_key' => 'starting_male_personality_multiple_appearance_little_important',
                'value' => 5,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],
            [
                'setting_key' => 'starting_male_personality_multiple_overall_point',
                'value' => 6,
                'category' => MatchingSettingCategory::StartingPoint,
                'type' => MatchingSettingType::OverallPoint
            ],

            [
                'setting_key' => 'male_specific_addon_multiple_appearance_little_important',
                'value' => 5,
                'category' => MatchingSettingCategory::SpecificAddonPoint
            ],
            [
                'setting_key' => 'male_specific_addon_multiple_appearance_more_important',
                'value' => 4,
                'category' => MatchingSettingCategory::SpecificAddonPoint
            ]
        ];
    }

    /**
     * Closed point battle settings
     *
     * @return array
     */
    protected function closedPointBattleSettings(): array
    {
        return [
            [
                'setting_key' => 'closed_point_battle_max_mismatch',
                'value' => - 10,
                'category' => MatchingSettingCategory::ClosedPointBattle,
                'type' => MatchingSettingType::ClosedPointBattle
            ],
            [
                'setting_key' => 'closed_point_battle_gap',
                'value' => - 10,
                'category' => MatchingSettingCategory::ClosedPointBattle,
                'type' => MatchingSettingType::ClosedPointBattle
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorityPointSettings = $this->getPriorityPointSettings();
        $overallPointSettings = $this->getOverallPointSettings();
        $closedPointBattleSettings = $this->closedPointBattleSettings();

        $settings = array_merge($priorityPointSettings, $overallPointSettings, $closedPointBattleSettings);

        foreach ($settings as $setting) {

            $this->matchingSettingRepository->firstOrCreate([
                'setting_key' => $setting['setting_key']
            ], $setting);
        }
    }
}
