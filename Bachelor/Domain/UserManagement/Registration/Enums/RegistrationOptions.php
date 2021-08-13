<?php
namespace Bachelor\Domain\UserManagement\Registration\Enums;

use BenSampo\Enum\Enum;

/**
 *
 * @method static static age()
 * @method static static profile_min_height()
 * @method static static profile_max_height()
 * @method static static profile_height()
 * @method static static partner_body_type()
 * @method static static profile_body_type()
 * @method static static character()
 * @method static static smoking()
 * @method static static drinking()
 * @method static static have_children()
 * @method static static divorce()
 * @method static static annual_income()
 * @method static static holiday()
 * @method static static education()
 * @method static static preferred_min_age()
 * @method static static preferred_max_age()
 * @method static static preferred_min_height()
 * @method static static preferred_max_height()
 * @method static static preferred_smoke()
 * @method static static preferred_body_shape()
 * @method static static preferred_drink()
 * @method static static preferred_divorced()
 * @method static static preferred_having_children()
 * @method static static preferred_annual_income()
 * @method static static preferred_education()
 * @method static static appearance_features()
 * @method static static important_preferences()
 * @method static static marriage_intention()
 * @method static static appearance_strength()
 * @method static static job()
 * @method static static preferred_job()
 * @method static static hobby()
 * @method static static education_group()
 * @method static static preferred_importance_of_looks()
 * @method static static preferred_character()
 * @method static static strengths_of_appearance()
 */
final class RegistrationOptions extends Enum
{

    const age = [
        'Male' => [
            [
                'value' => 23, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Min Male Age', 'display_name' => 'Select Male min Age'],
                    [ 'label_name'=> 'Min Male Age', 'display_name' => '相手の年齢(最小)を選択してください'
                    ]
                ]
            ],
            [
                'value' => 45, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Max Male Age', 'display_name' => 'Select Male max Age'],
                    [ 'label_name'=> 'Max Male Age', 'display_name' => '相手の年齢(最大)を選択してください'
                    ]
                ]
            ]
        ],
        'Female' => [
            [
                'value' => 20, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Min FeMale Age', 'display_name' => 'Select Female min age'],
                    [ 'label_name'=> 'Min FeMale Age', 'display_name' => '相手の年齢(最小)を選択してください'
                    ]
                ]
            ],
            [
                'value' => 35, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Max FeMale Age', 'display_name' => 'Select Female max age'],
                    [ 'label_name'=> 'Max FeMale Age', 'display_name' => '相手の年齢(最大)を選択してください'
                    ]
                ]
            ]
        ]
    ];

    const profile_min_height = [
        'Male' => [
            [
                'value' => 160, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Min Male Height', 'display_name' => 'Male Min Height'],
                    [ 'label_name'=> 'Min Male Height', 'display_name' => '相手の身長(最小)'
                    ]
                ]
            ]
        ],
        'Female' => [
            [
                'value' => 150, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'FeMale Min Height', 'display_name' => 'Select Female min age'],
                    [ 'label_name'=> 'FeMale Min Height', 'display_name' => '相手の身長(最小)'
                    ]
                ]
            ]
        ]
    ];

    const profile_max_height = [
        'Male' => [
            [
                'value' => 190, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Max Male Height', 'display_name' => 'Max Male Height'],
                    [ 'label_name'=> 'Max Male Height', 'display_name' => '相手の身長(最大)'
                    ]
                ]
            ]
        ],
        'Female' => [
            [
                'value' => 180, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Max FeMale Height', 'display_name' => 'Max FeMale Height'],
                    [ 'label_name'=> 'Max FeMale Height', 'display_name' => '相手の身長(最大)'
                    ]
                ]
            ]
        ]
    ];

    const partner_body_type = [
        'neutral' => [
            ['value' => 1, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Skinny', 'display_name' => 'Skinny'],
                    ['label_name' => 'スリム', 'display_name' => 'スリム']
                ]
            ],
            ['value' => 2, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Skinny Fit', 'display_name' => 'Skinny Fit'],
                    ['label_name' => 'やや細め', 'display_name' => 'やや細め']
                ]
            ],
            ['value' => 3, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Fit', 'display_name' => 'Fit'],
                    ['label_name' => '普通', 'display_name' => '普通']
                ]
            ],
        ],
        'Female' => [
            ['value' => 4, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Curvy', 'display_name' => 'Curvy'],
                    ['label_name' => 'グラマー', 'display_name' => 'グラマー']
                ]
            ],
            ['value' => 5, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Chubby', 'display_name' => 'Chubby'],
                    ['label_name' => 'グラマー', 'display_name' => 'グラマー']
                ]
            ],
        ],
		'Male' => [
            ['value' => 4, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Curvy', 'display_name' => 'Curvy'],
                    ['label_name' => '筋肉質', 'display_name' => '筋肉質']
                ]
            ],
            ['value' => 5, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Chubby', 'display_name' => 'Chubby'],
                    ['label_name' => 'やや太め', 'display_name' => 'やや太め']
                ]
            ],
        ]
    ];

    const character = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'kind', 'display_name' => 'kind'],
                    [ 'label_name'=> 'kind', 'display_name' => '優しい'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Funny', 'display_name' => 'Funny'],
                    [ 'label_name'=> 'Funny', 'display_name' => '面白い'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Happy', 'display_name' => 'Happy'],
                    [ 'label_name'=> 'Happy', 'display_name' => '明るい'
                    ]
                ]
            ],
            [
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Intelligent', 'display_name' => 'Intelligent'],
                    [ 'label_name'=> 'Intelligent', 'display_name' => '知的'
                    ]
                ]
            ],
            [
                'value' => 5, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Sincere', 'display_name' => 'Sincere'],
                    [ 'label_name'=> 'Sincere', 'display_name' => '誠実'
                    ]
                ]
            ],
            [
                'value' => 7, 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Helpful', 'display_name' => 'Helpful'],
                    [ 'label_name'=> 'Helpful', 'display_name' => '面倒見が良い'
                    ]
                ]
            ],
            [
                'value' => 8, 'sort' => 8, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Calm', 'display_name' => 'Calm'],
                    [ 'label_name'=> 'Calm', 'display_name' => '落ち着きがある'
                    ]
                ]
            ],
            [
                'value' => 10, 'sort' => 10, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Caring', 'display_name' => 'Caring'],
                    [ 'label_name'=> 'Caring', 'display_name' => '気がきく'
                    ]
                ]
            ],
			[
                'value' => 6, 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Decisive', 'display_name' => 'Decisive'],
                    [ 'label_name'=> 'Decisive', 'display_name' => '決断力がある'
                    ]
                ]
            ],
            [
                'value' => 9, 'sort' => 9, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Passionate', 'display_name' => 'Passionate'],
                    [ 'label_name'=> 'Passionate', 'display_name' => '情熱的'
                    ]
                ]
            ],
			[
                'value' => 14, 'sort' => 14, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Curious', 'display_name' => 'Curious'],
                    [ 'label_name'=> 'Curious', 'display_name' => '好奇心旺盛'
                    ]
                ]
            ],
            [
                'value' => 15, 'sort' => 15, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Good Listener', 'display_name' => 'Good Listener'],
                    [ 'label_name'=> 'Good Listener', 'display_name' => '聞き上手'
                    ]
                ]
            ]
		],
        'Male' => [
			[
                'value' => 11, 'sort' => 11, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Generous', 'display_name' => 'Generous'],
                    [ 'label_name'=> 'Generous', 'display_name' => '気前がいい'
                    ]
                ]
            ],
            [
                'value' => 13, 'sort' => 13, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Job Lover', 'display_name' => 'Job Lover'],
                    [ 'label_name'=> 'Job Lover', 'display_name' => '仕事好き'
                    ]
                ]
            ]
        ],
        'Female' => [
			[
                'value' => 12, 'sort' => 12, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Homely', 'display_name' => 'Homely'],
                    [ 'label_name'=> 'Homely', 'display_name' => '家庭的'
                    ]
                ]
            ],
            [
                'value' => 16, 'sort' => 16, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Elegant', 'display_name' => 'Elegant'],
                    [ 'label_name'=> 'Elegant', 'display_name' => '上品'
                    ]
                ]
            ],
            [
                'value' => 17, 'sort' => 17, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Lonely', 'display_name' => 'Lonely'],
                    [ 'label_name'=> 'Lonely', 'display_name' => '寂しがり'
                    ]
                ]
            ],
            [
                'value' => 18, 'sort' => 18, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Shy', 'display_name' => 'Shy'],
                    [ 'label_name'=> 'Shy', 'display_name' => '奥手'
                    ]
                ]
            ],
            [
                'value' => 19, 'sort' => 19, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Independent', 'display_name' => 'Independent'],
                    [ 'label_name'=> 'Independent', 'display_name' => '自立している'
                    ]
                ]
            ],
            [
                'value' => 20, 'sort' => 20, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Goofy', 'display_name' => 'Goofy'],
                    [ 'label_name'=> 'Goofy', 'display_name' => '天然'
                    ]
                ]
            ],
            [
                'value' => 21, 'sort' => 21, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Tolerant', 'display_name' => 'Tolerant'],
                    [ 'label_name'=> 'Tolerant', 'display_name' => '寛容'
                    ]
                ]
            ]
        ]
    ];

    const smoking = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Non Smoker', 'display_name' => 'Non Smoker'],
                    [ 'label_name'=> 'Non Smoker', 'display_name' => '吸わない'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Sometimes', 'display_name' => 'Sometimes'],
                    [ 'label_name'=> 'Sometimes', 'display_name' => 'ときどき吸う'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Give up if partner hates it', 'display_name' => 'Give up if partner hates it'],
                    [ 'label_name'=> 'Give up if partner hates it', 'display_name' => '相手が嫌ならやめる'
                    ]
                ]
            ],
            [
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Electronic Cigarette', 'display_name' => 'Electronic Cigarette'],
                    [ 'label_name'=> 'Electronic Cigarette', 'display_name' => '吸う（電子タバコ）'
                    ]
                ]
            ],
            [
                'value' => 5, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Frequently', 'display_name' => 'Frequently'],
                    [ 'label_name'=> 'Frequently', 'display_name' => '吸う'
                    ]
                ]
            ]
        ]
    ];

    const drinking = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Frequently', 'display_name' => 'Frequently'],
                    [ 'label_name'=> 'Frequently', 'display_name' => '飲む'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Not At All', 'display_name' => 'Not At All'],
                    [ 'label_name'=> 'Not At All', 'display_name' => '飲まない'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Sometimes', 'display_name' => 'Sometimes'],
                    [ 'label_name'=> 'Sometimes', 'display_name' => 'ときどき飲む'
                    ]
                ]
            ]
        ]
    ];

    const have_children = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Not At All', 'display_name' => 'Not At All'],
                    [ 'label_name'=> 'Not At All', 'display_name' => 'いない'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Living together', 'display_name' => 'Living together'],
                    [ 'label_name'=> 'Living together', 'display_name' => '同居中'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Separate', 'display_name' => 'Separate'],
                    [ 'label_name'=> 'Separate', 'display_name' => '別居中'
                    ]
                ]
            ]
        ]
    ];

    const divorce = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'No history of divorce', 'display_name' => 'No history of divorce'],
                    [ 'label_name'=> 'No history of divorce', 'display_name' => 'なし'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Divorced/No kids', 'display_name' => 'Divorced/No kids'],
                    [ 'label_name'=> 'Divorced/No kids', 'display_name' => 'あり（子供なし）'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Divorced/Have kids but living separately', 'display_name' => 'Divorced/Have kids but living separately'],
                    [ 'label_name'=> 'Divorced/Have kids but living separately', 'display_name' => 'あり（子供あり：別居）'
                    ]
                ]
            ],
            [
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Divorced/Have kids and living together', 'display_name' => 'Divorced/Have kids and living together'],
                    [ 'label_name'=> 'Divorced/Have kids and living together', 'display_name' => 'あり（子供あり：同居）'
                    ]
                ]
            ]
        ]
    ];

    const annual_income = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> '3  ~ 4 Million Yen', 'display_name' => '3  ~ 4 Million Yen'],
                    [ 'label_name'=> '3  ~ 4 Million Yen', 'display_name' => '300万円~400万円'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> '4  ~ 6 Million Yen', 'display_name' => '4  ~ 6 Million Yen'],
                    [ 'label_name'=> '4  ~ 6 Million Yen', 'display_name' => '400万円~600万円'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> '8 Million or Less Yen', 'display_name' => '8 Million or Less Yen'],
                    [ 'label_name'=> '8 Million or Less Yen', 'display_name' => '600万円~800万円'
                    ]
                ]
            ],
            [
                'value' => 4, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> '8 Million Yen ~ 10 Million Yen', 'display_name' => '8 Million Yen ~ 10 Million Yen'],
                    [ 'label_name'=> '8 Million Yen ~ 10 Million Yen', 'display_name' => '800万円~1000万円'
                    ]
                ]
            ],
            [
                'value' => 5, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> '10 Million Yen ~ 15 Million Yen', 'display_name' => '10 Million Yen ~ 15 Million Yen'],
                    [ 'label_name'=> '10 Million Yen ~ 15 Million Yen', 'display_name' => '1000万円~1500万円'
                    ]
                ]
            ],
            [
                'value' => 6, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> '15 Million Yen ~ 20 Million Yen', 'display_name' => '15 Million Yen ~ 20 Million Yen'],
                    [ 'label_name'=> '15 Million Yen ~ 20 Million Yen', 'display_name' => '1500万円~2000万円'
                    ]
                ]
            ],
            [
                'value' => 7, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> '20 Million Yen ~ 30 Million Yen', 'display_name' => '20 Million Yen ~ 30 Million Yen' ],// TODO Incorrect display name. Please fix this
                    [ 'label_name'=> '20 Million Yen ~ 30 Million Yen', 'display_name' => '2000万円~3000万円']
                ]
            ],
            [
                'value' => 8, 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> '30 Million Yen ~ 50 Million Yen', 'display_name' => '30 Million Yen ~ 50 Million Yen'],
                    [ 'label_name'=> '30 Million Yen ~ 50 Million Yen', 'display_name' => '3000万円~5000万円'
                    ]
                ]
            ],
            [
                'value' => 9, 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'More Than 50 Million Yen', 'display_name' => 'More Than 50 Million Yen' ],// TODO Incorrect display name. Please fix this
                    [ 'label_name'=> 'More Than 50 Million Yen', 'display_name' => '5000万円以上']
                ]
            ]
        ]
    ];

    const holiday = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Weekday', 'display_name' => 'Weekday'],
                    [ 'label_name'=> 'Weekday', 'display_name' => '平日'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Weekend', 'display_name' => 'Weekend'],
                    [ 'label_name'=> 'Weekend', 'display_name' => '土日'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Irregular', 'display_name' => 'Irregular'],
                    [ 'label_name'=> 'Irregular', 'display_name' => '不定期'
                    ]
                ]
            ],
            [
                'value' => 99, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Other', 'display_name' => 'Other'],
                    [ 'label_name'=> 'Other', 'display_name' => 'その他'
                    ]
                ]
            ]
        ]
    ];

    const education = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Master', 'display_name' => 'Master'],
                    [ 'label_name'=> 'Master', 'display_name' => '大学院卒'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Bachelor', 'display_name' => 'Bachelor'],
                    [ 'label_name'=> 'Bachelor', 'display_name' => '大学卒'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Associate / Diploma', 'display_name' => 'Associate / Diploma'],
                    [ 'label_name'=> 'Associate / Diploma', 'display_name' => '短大/専門学校卒'
                    ]
                ]
            ],
            [
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'High school graduation', 'display_name' => 'High school graduation'],
                    [ 'label_name'=> 'High school graduation', 'display_name' => '高校卒'
                    ]
                ]
            ],
            [
                'value' => 99, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Other', 'display_name' => 'Other'],
                    [ 'label_name'=> 'Other', 'display_name' => 'その他'
                    ]
                ]
            ]
        ]
    ];

    const preferred_min_age = [
        'Male' => [
            [
                'value' => 20, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Preferred Male Minimum Age', 'display_name' => 'Preferred Male Minimum Age'],
                    [ 'label_name'=> 'Preferred Male Minimum Age', 'display_name' => '相手の年齢(最小)'
                    ]
                ]
            ]
        ],
        'Female' => [
            [
                'value' => 23, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Preferred FeMale Minimum Age', 'display_name' => 'Preferred FeMale Minimum Age'],
                    [ 'label_name'=> 'Preferred FeMale Minimum Age', 'display_name' => '相手の年齢(最小)'
                    ]
                ]
            ]
        ]
    ];

    const preferred_max_age = [
        'Male' => [
            [
                'value' => 45, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Preferred Male Maximum Age', 'display_name' => 'Preferred Male Maximum Age'],
                    [ 'label_name'=> 'Preferred Male Maximum Age', 'display_name' => '相手の年齢(最大)'
                    ]
                ]
            ]
        ],
        'Female' => [
            [
                'value' => 50, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Preferred FeMale Maximum Age', 'display_name' => 'Preferred FeMale Maximum Age'],
                    [ 'label_name'=> 'Preferred FeMale Maximum Age', 'display_name' => '相手の年齢(最大)'
                    ]
                ]
            ]
        ]
    ];

    const preferred_min_height = [
        'Male' => [
            [
                'value' => 149, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Preferred Male Minimum Height', 'display_name' => 'Less Than 149'],
                    [ 'label_name'=> 'Preferred Male Minimum Height', 'display_name' => '149cm以下'
                    ]
                ]
            ]
        ],
        'Female' => [
            [
                'value' => 159, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Preferred FeMale minimum Height', 'display_name' => 'Less Than 159'],
                    [ 'label_name'=> 'Preferred FeMale minimum Height', 'display_name' => '159cm以下'
                    ]
                ]
            ]
        ]
    ];

    const preferred_max_height = [
        'Male' => [
            [
                'value' => 181, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Preferred Male Maximum Height', 'display_name' => 'More Than 181'],
                    [ 'label_name'=> 'Preferred Male Maximum Height', 'display_name' => '181cm以上'
                    ]
                ]
            ]
        ],
        'Female' => [
            [
                'value' => 191, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Preferred FeMale maximum Height', 'display_name' => 'More Than 191'],
                    [ 'label_name'=> 'Preferred FeMale maximum Height', 'display_name' => '191cm以上'
                    ]
                ]
            ]
        ]
    ];

    const preferred_smoke = [
        'neutral' => [
            [
                'value' => 0, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => 'I Don\'t Mind'],
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => '気にしない'
                    ]
                ]
            ],
            [
                'value' => 1, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Electrical Smoker Is OK', 'display_name' => 'Electrical Smoker Is OK'],
                    [ 'label_name'=> 'Electrical Smoker Is OK', 'display_name' => '電子タバコならOK'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Sometimes Is OK', 'display_name' => 'Sometimes Is OK'],
                    [ 'label_name'=> 'Sometimes Is OK', 'display_name' => '時々ならOK'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Prefer Not Smoker', 'display_name' => 'Prefer Not Smoker'],
                    [ 'label_name'=> 'Prefer Not Smoker', 'display_name' => '吸わない人がいい'
                    ]
                ]
            ]
        ]
    ];

    const preferred_body_shape = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Skinny', 'display_name' => 'Skinny'],
                    ['label_name' => 'Skinny', 'display_name' => 'スリム']
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Skinny Fit', 'display_name' => 'Skinny Fit'],
                    ['label_name' => 'Skinny Fit', 'display_name' => 'やや細め']
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Fit', 'display_name' => 'Fit'],
                    ['label_name' => 'Fit', 'display_name' => '普通']
                ]
            ],
            [
                'value' => 5, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Chubby', 'display_name' => 'Chubby'],
                    ['label_name' => 'Chubby', 'display_name' => 'ややぽっちゃり']
                ]
            ]
		],
		'Male' => [
			[
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Curvy', 'display_name' => 'Curvy'],
                    ['label_name' => 'Curvy', 'display_name' => 'グラマー']
                ]
            ]
		],
		'Female' => [
			[
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Curvy', 'display_name' => 'Curvy'],
                    ['label_name' => 'Curvy', 'display_name' => '筋肉質']
                ]
            ]
        ]
    ];

    const preferred_drink = [
        'neutral' => [
            [
                'value' => 0, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => 'I Don\'t Mind'],
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => '気にしない'
                    ]
                ]
            ],
            [
                'value' => 1, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Prefers Drinker', 'display_name' => 'Prefers Drinker'],
                    [ 'label_name'=> 'Prefers Drinker', 'display_name' => '飲む人がいい'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Sometimes Is OK', 'display_name' => 'Sometimes Is OK'],
                    [ 'label_name'=> 'Sometimes Is OK', 'display_name' => 'ときどき飲む人がいい'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Prefer Not Drinker', 'display_name' => 'Prefer Not Drinker'],
                    [ 'label_name'=> 'Prefer Not Drinker', 'display_name' => '飲まないで欲しい'
                    ]
                ]
            ]
        ]
    ];

    const preferred_divorced = [
        'neutral' => [
            [
                'value' => 0, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => 'I Don\'t Mind'],
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => '気にしない'
                    ]
                ]
            ],
            [
                'value' => 1, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'No history of divorce/No kids', 'display_name' => 'No history of divorce/No kids'],
                    [ 'label_name'=> 'No history of divorce/No kids', 'display_name' => 'なしがいい'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Divorced OK but should have No kids', 'display_name' => 'Divorced OK but should have No kids'],
                    [ 'label_name'=> 'Divorced OK but should have No kids', 'display_name' => '子供なしならいい'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Divorced OK / Have kids OK but must live separately', 'display_name' => 'Divorced OK / Have kids OK but must live separately'],
                    [ 'label_name'=> 'Divorced OK / Have kids OK but must live separately', 'display_name' => '別居していればいい'
                    ]
                ]
            ]
        ]
    ];

    const preferred_having_children = [
        'neutral' => [
            [
                'value' => 0, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => 'I Don\'t Mind'],
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => '気にしない'
                    ]
                ]
            ],
            [
                'value' => 1, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Living Separately Is Ok', 'display_name' => 'Living Separately Is Ok'],
                    [ 'label_name'=> 'Living Separately Is Ok', 'display_name' => '子供別居ならいい'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Prefer Not Having Children', 'display_name' => 'Prefer Not Having Children'],
                    [ 'label_name'=> 'Prefer Not Having Children', 'display_name' => 'Prefer Not Having Children'
                    ]
                ]
            ]
        ]
    ];

    const preferred_annual_income = [
        'neutral' => [
            [
                'value' => 2, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => 'I Don\'t Mind'],
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => '気にしない'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'More Than 4 Million Yen', 'display_name' => 'More Than 4 Million Yen'],
                    [ 'label_name'=> 'More Than 4 Million Yen', 'display_name' => '400万~'
                    ]
                ]
            ],
            [
                'value' => 4, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'More Than 6 Million Yen', 'display_name' => 'More Than 6 Million Yen'],
                    [ 'label_name'=> 'More Than 6 Million Yen', 'display_name' => '600万〜'
                    ]
                ]
            ],
            [
                'value' => 5, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'More Than 8 Million Yen', 'display_name' => 'More Than 8 Million Yen'],
                    [ 'label_name'=> 'More Than 8 Million Yen', 'display_name' => '800万~'
                    ]
                ]
            ],
            [
                'value' => 6, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'More Than 10 Million Yen', 'display_name' => 'More Than 10 Million Yen'],
                    [ 'label_name'=> 'More Than 10 Million Yen', 'display_name' => '1000万~'
                    ]
                ]
            ],
            [
                'value' => 7, 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'More Than 15 Million Yen', 'display_name' => 'More Than 15 Million Yen'],
                    [ 'label_name'=> 'More Than 15 Million Yen', 'display_name' => '1500万~'
                    ]
                ]
            ],
            [
                'value' => 8, 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'More Than 20 Million Yen', 'display_name' => 'More Than 20 Million Yen'],
                    [ 'label_name'=> 'More Than 20 Million Yen', 'display_name' => '2000万~'
                    ]
                ]
            ],
        ]
    ];

    const preferred_education = [
        'neutral' => [
            [
                'value' => 0, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => 'I Don\'t Mind'],
                    [ 'label_name'=> 'I Don\'t Mind', 'display_name' => '気にしない'
                    ]
                ]
            ],
            [
                'value' => 1, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Prefer More Than Uni', 'display_name' => 'Prefer More Than Uni'],
                    [ 'label_name'=> 'Prefer More Than Uni', 'display_name' => '大学卒ならいい'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Prefer More Than Famous Uni', 'display_name' => 'Prefer More Than Famous Uni'],
                    [ 'label_name'=> 'Prefer More Than Famous Uni', 'display_name' => '有名大学卒がいい'
                    ]
                ]
            ]
        ]
    ];

    const appearance_features = [
        'neutral' => [
            [
                'value' => 'fe_00', 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Single Eyelids', 'display_name' => 'Single Eyelids'],
                    [ 'label_name'=> 'Single Eyelids', 'display_name' => '一重'
                    ]
                ]
            ],
            [
                'value' => 'fe_01', 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Double Eyelids', 'display_name' => 'Double Eyelids'],
                    [ 'label_name'=> 'Double Eyelids', 'display_name' => '二重'
                    ]
                ]
            ],
            [
                'value' => 'fe_02', 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Short Hair', 'display_name' => 'Short Hair'],
                    [ 'label_name'=> 'Short Hair', 'display_name' => 'ショートヘア'
                    ]
                ]
            ],
            [
                'value' => 'fe_03', 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Long Hair', 'display_name' => 'Long Hair'],
                    [ 'label_name'=> 'Long Hair', 'display_name' => 'ロングヘア'
                    ]
                ]
            ],
            [
                'value' => 'fe_04', 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Black Hair', 'display_name' => 'Black Hair'],
                    [ 'label_name'=> 'Black Hair', 'display_name' => '黒髪'
                    ]
                ]
            ],
            [
                'value' => 'fe_05', 'sort' => 12, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Color Hair', 'display_name' => 'Color Hair'],
                    [ 'label_name'=> 'Color Hair', 'display_name' => 'カラーヘア'
                    ]
                ]
            ],
            [
                'value' => 'fe_06', 'sort' => 11, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Thin Eyebrow', 'display_name' => 'Thin Eyebrow'],
                    [ 'label_name'=> 'Thin Eyebrow', 'display_name' => '眉は細め'
                    ]
                ]
            ],
            [
                'value' => 'fe_07', 'sort' => 10, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Thick Eyebrow', 'display_name' => 'Thick Eyebrow'],
                    [ 'label_name'=> 'Thick Eyebrow', 'display_name' => '眉は太め'
                    ]
                ]
            ],
            [
                'value' => 'fe_08', 'sort' => 9, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Black Skin', 'display_name' => 'Black Skin'],
                    [ 'label_name'=> 'Black Skin', 'display_name' => '色黒'
                    ]
                ]
            ],
            [
                'value' => 'fe_09', 'sort' => 8, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'White Skin', 'display_name' => 'White Skin'],
                    [ 'label_name'=> 'White Skin', 'display_name' => '色白'
                    ]
                ]
            ],
            [
                'value' => 'fe_10', 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Rounded Face', 'display_name' => 'Rounded Face'],
                    [ 'label_name'=> 'Rounded Face', 'display_name' => '丸顔'
                    ]
                ]
            ],
            [
                'value' => 'fe_11', 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Square Face', 'display_name' => 'Square Face'],
                    [ 'label_name'=> 'Square Face', 'display_name' => '四角顔'
                    ]
                ]
            ]
        ]
    ];

    const important_preferences = [
        'Female' => [
            [
                'value' => 4, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Smoke', 'display_name' => 'Smoke'],
                    [ 'label_name'=> 'Smoke', 'display_name' => 'タバコ'
                    ]
                ]
            ]
        ],
        'neutral' => [
            [
                'value' => 0, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Age', 'display_name' => 'Age'],
                    [ 'label_name'=> 'Age', 'display_name' => '年齢'
                    ]
                ]
            ],
            [
                'value' => 1, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Height', 'display_name' => 'Height'],
                    [ 'label_name'=> 'Height', 'display_name' => '身長'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Body Shape', 'display_name' => 'Body Shape'],
                    [ 'label_name'=> 'Body Shape', 'display_name' => '体型'
                    ]
                ]
            ],
            [
                'value' => 5, 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Drink Or Not', 'display_name' => 'Drink Or Not'],
                    [ 'label_name'=> 'Drink Or Not', 'display_name' => 'お酒'
                    ]
                ]
            ],
            [
                'value' => 6, 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Divorce / Children', 'display_name' => 'Divorce / Children'],
                    [ 'label_name'=> 'Divorce / Children', 'display_name' => '離婚歴'
                    ]
                ]
            ],
            [
                'value' => 8, 'sort' => 9, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Marriage Intention', 'display_name' => 'Marriage Intention'],
                    [ 'label_name'=> 'Marriage Intention', 'display_name' => '結婚に対する意思'
                    ]
                ]
            ],
            [
                'value' => 9, 'sort' => 10, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Education', 'display_name' => 'Education'],
                    [ 'label_name'=> 'Education', 'display_name' => '卒業'
                    ]
                ]
            ],
            [
                'value' => 10, 'sort' => 11, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Annual Income', 'display_name' => 'Annual Income'],
                    [ 'label_name'=> 'Annual Income', 'display_name' => '年収'
                    ]
                ]
            ],
            [
                'value' => 12, 'sort' => 13, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Face Appearance', 'display_name' => 'Face Appearance'],
                    [ 'label_name'=> 'Face Appearance', 'display_name' => '顔の特徴'
                    ]
                ]
            ],
            [
                'value' => 13, 'sort' => 14, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Hobby', 'display_name' => 'Hobby'],
                    [ 'label_name'=> 'Hobby', 'display_name' => '趣味'
                    ]
                ]
            ],
		],
        'Male' => [
			[
                'value' => 14, 'sort' => 15, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Job', 'display_name' => 'Job'],
                    [ 'label_name'=> 'Job', 'display_name' => '仕事'
                    ]
                ]
            ]
        ]
    ];

    const marriage_intention = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'As Soon As Possible', 'display_name' => 'As Soon As Possible'],
                    [ 'label_name'=> 'As Soon As Possible', 'display_name' => 'すぐにでもしたい'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'It\'s When I Can See Good Person', 'display_name' => 'It\'s When I Can See Good Person'],
                    [ 'label_name'=> 'It\'s When I Can See Good Person', 'display_name' => 'いい人がいたらしたい'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'I Don\'t Want Now', 'display_name' => 'I Don\'t Want Now'],
                    [ 'label_name'=> 'I Don\'t Want Now', 'display_name' => '今は考えていない'
                    ]
                ]
            ]
        ]
    ];

    const appearance_strength = [
        'neutral' => [
            ['value' => 'st_01', 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Eyes', 'display_name' => 'Beautiful Eyes'],
                    ['label_name' => 'ぱっちりした目', 'display_name' => 'ぱっちりした目']
                ]
            ],
            ['value' => 'st_02', 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Nose', 'display_name' => 'Beautiful Nose'],
                    ['label_name' => '鼻筋', 'display_name' => '鼻筋']
                ]
            ],
            ['value' => 'st_03', 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Smile', 'display_name' => 'Beautiful Smile'],
                    ['label_name' => '笑顔', 'display_name' => '笑顔']
                ]
            ],
            ['value' => 'st_04', 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Face Shape', 'display_name' => 'Beautiful Face Shape'],
                    ['label_name' => '笑顔', 'display_name' => '笑顔']
                ]
            ],
            ['value' => 'st_08', 'sort' => 8, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Black Hair', 'display_name' => 'Black Hair'],
                    ['label_name' => '黒髪', 'display_name' => '黒髪']
                ]
            ],
            ['value' => 'st_12', 'sort' => 12, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Teeth', 'display_name' => 'Beautiful Teeth'],
                    ['label_name' => '歯並び', 'display_name' => '歯並び']
                ]
            ],
            ['value' => 'st_14', 'sort' => 14, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Skin', 'display_name' => 'Beautiful Skin'],
                    ['label_name' => '肌', 'display_name' => '肌']
                ]
            ],
            ['value' => 'st_15', 'sort' => 15, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'White Skin', 'display_name' => 'White Skin'],
                    ['label_name' => '色白', 'display_name' => '色白']
                ]
            ],
            ['value' => 'st_16', 'sort' => 16, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Sexy', 'display_name' => 'Sexy'],
                    ['label_name' => '色気', 'display_name' => '色気']
                ]
            ],
        ],
        'Male' => [
            ['value' => 'st_05', 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Rounded Face', 'display_name' => 'Rounded Face'],
                    ['label_name' => '丸顔', 'display_name' => '丸顔']
                ]
            ],
            ['value' => 'st_06', 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Long Hair', 'display_name' => 'Long Hair'],
                    ['label_name' => 'ロングヘア', 'display_name' => 'ロングヘア']
                ]
            ],
            ['value' => 'st_07', 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Short Hair', 'display_name' => 'Short Hair'],
                    ['label_name' => 'ショートヘア', 'display_name' => 'ショートヘア']
                ]
            ],
            ['value' => 'st_13', 'sort' => 17, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Dimple', 'display_name' => 'Dimple'],
                    ['label_name' => 'えくぼ', 'display_name' => 'えくぼ']
                ]
            ],
        ],
        'Female' => [
            ['value' => 'st_07', 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Short Hair', 'display_name' => 'Short Hair'],
                    ['label_name' => '短髪', 'display_name' => '短髪']
                ]
            ],
            ['value' => 'st_09', 'sort' => 9, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Single Eyelids', 'display_name' => 'Single Eyelids'],
                    ['label_name' => '一重', 'display_name' => '一重']
                ]
            ],
            ['value' => 'st_010', 'sort' => 10, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Smile Lines', 'display_name' => 'Smile Lines'],
                    ['label_name' => '笑いジワ', 'display_name' => '笑いジワ']
                ]
            ],
            ['value' => 'st_011', 'sort' => 11, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Voluptuous / Hunky', 'display_name' => 'Voluptuous / Hunky'],
                    ['label_name' => '筋肉質', 'display_name' => '筋肉質']
                ]
            ],
        ]
    ];

    const job = [
        'Male' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Managers and officials', 'display_name' => 'Managers and officials'],
                    ['label_name' => 'Managers and officials', 'display_name' => '経営者']
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Officer', 'display_name' => 'Officer'],
                    [ 'label_name'=> 'Officer', 'display_name' => '役員'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Doctor', 'display_name' => 'Doctor'],
                    [ 'label_name'=> 'Doctor', 'display_name' => '医師'
                    ]
                ]
            ],
            [
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'government official', 'display_name' => 'government official'],
                    [ 'label_name'=> 'government official', 'display_name' => '国家公務員'
                    ]
                ]
            ],
            [
                'value' => 5, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Listed companies (the First Section of the Tokyo Stock Exchange)', 'display_name' => 'Listed companies (the First Section of the Tokyo Stock Exchange)'],
                    [ 'label_name'=> 'Listed companies (the First Section of the Tokyo Stock Exchange)', 'display_name' => '上場企業'
                    ]
                ]
            ],
            [
                'value' => 6, 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Investor', 'display_name' => 'Investor'],
                    [ 'label_name'=> 'Investor', 'display_name' => '投資家'
                    ]
                ]
            ],
            [
                'value' => 7, 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Dentist', 'display_name' => 'Dentist'],
                    [ 'label_name'=> 'Dentist', 'display_name' => '歯科医師'
                    ]
                ]
            ],
            [
                'value' => 8, 'sort' => 8, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'lawyer', 'display_name' => 'lawyer'],
                    [ 'label_name'=> 'lawyer', 'display_name' => '弁護士'
                    ]
                ]
            ],
            [
                'value' => 9, 'sort' => 9, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Accountants', 'display_name' => 'Accountants'],
                    [ 'label_name'=> 'Accountants', 'display_name' => '会計士'
                    ]
                ]
            ]
        ],
        'Female' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Managers and officials', 'display_name' => 'Managers and officials'],
                    [ 'label_name'=> 'Managers and officials', 'display_name' => '経営者'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Officer', 'display_name' => 'Officer'],
                    [ 'label_name'=> 'Officer', 'display_name' => '役員'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Doctor', 'display_name' => 'Doctor'],
                    [ 'label_name'=> 'Doctor', 'display_name' => '医師'
                    ]
                ]
            ],
            [
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'government official', 'display_name' => 'government official'],
                    [ 'label_name'=> 'government official', 'display_name' => '国家公務員'
                    ]
                ]
            ],
            [
                'value' => 5, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Listed companies (the First Section of the Tokyo Stock Exchange)', 'display_name' => 'Listed companies (the First Section of the Tokyo Stock Exchange)'],
                    [ 'label_name'=> 'Listed companies (the First Section of the Tokyo Stock Exchange)', 'display_name' => '上場企業'
                    ]
                ]
            ],
            [
                'value' => 6, 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Investor', 'display_name' => 'Investor'],
                    [ 'label_name'=> 'Investor', 'display_name' => '投資家'
                    ]
                ]
            ],
            [
                'value' => 7, 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Dentist', 'display_name' => 'Dentist'],
                    [ 'label_name'=> 'Dentist', 'display_name' => '歯科医師'
                    ]
                ]
            ],
            [
                'value' => 8, 'sort' => 8, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'lawyer', 'display_name' => 'lawyer'],
                    [ 'label_name'=> 'lawyer', 'display_name' => '弁護士'
                    ]
                ]
            ],
            [
                'value' => 9, 'sort' => 9, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Accountants', 'display_name' => 'Accountants'],
                    [ 'label_name'=> 'Accountants', 'display_name' => '会計士'
                    ]
                ]
            ]
        ],
        'neutral' => [
            [
                'value' => 10, 'sort' => 10, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'pilot', 'display_name' => 'pilot'],
                    [ 'label_name'=> 'pilot', 'display_name' => 'パイロット'
                    ]
                ]
            ],
            [
                'value' => 11, 'sort' => 11, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Flight attendant', 'display_name' => 'Flight attendant'],
                    [ 'label_name'=> 'Flight attendant', 'display_name' => '客室乗務員'
                    ]
                ]
            ],
            [
                'value' => 12, 'sort' => 12, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Model', 'display_name' => 'Model'],
                    [ 'label_name'=> 'Model', 'display_name' => 'モデル・俳優/女優'
                    ]
                ]
            ],
            [
                'value' => 13, 'sort' => 13, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Entertainment', 'display_name' => 'Entertainment'],
                    [ 'label_name'=> 'Entertainment', 'display_name' => '芸能関係'
                    ]
                ]
            ],
            [
                'value' => 14, 'sort' => 14, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'announcer', 'display_name' => 'announcer'],
                    [ 'label_name'=> 'announcer', 'display_name' => 'アナウンサー'
                    ]
                ]
            ],
            [
                'value' => 15, 'sort' => 15, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Large companies', 'display_name' => 'Large companies'],
                    [ 'label_name'=> 'Large companies', 'display_name' => '大手企業'
                    ]
                ]
            ],
            [
                'value' => 16, 'sort' => 16, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Bank', 'display_name' => 'Bank'],
                    [ 'label_name'=> 'Bank', 'display_name' => '銀行'
                    ]
                ]
            ],
            [
                'value' => 17, 'sort' => 17, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Trading company', 'display_name' => 'Trading company'],
                    [ 'label_name'=> 'Trading company', 'display_name' => '商社'
                    ]
                ]
            ],
            [
                'value' => 18, 'sort' => 18, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Foreign financial', 'display_name' => 'Foreign financial'],
                    [ 'label_name'=> 'Foreign financial', 'display_name' => '外資金融'
                    ]
                ]
            ],
            [
                'value' => 19, 'sort' => 19, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Consultant', 'display_name' => 'Consultant'],
                    [ 'label_name'=> 'Consultant', 'display_name' => 'コンサルタント'
                    ]
                ]
            ],
            [
                'value' => 20, 'sort' => 20, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Foreign manufacturers', 'display_name' => 'Foreign manufacturers'],
                    [ 'label_name'=> 'Max FeMale Height', 'display_name' => '外資メーカー'
                    ]
                ]
            ],
            [
                'value' => 21, 'sort' => 21, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Judicial scrivener', 'display_name' => 'Judicial scrivener'],
                    [ 'label_name'=> 'Judicial scrivener', 'display_name' => '司法書士'
                    ]
                ]
            ],
            [
                'value' => 22, 'sort' => 22, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Administrative scrivener', 'display_name' => 'Administrative scrivener'],
                    [ 'label_name'=> 'Administrative scrivener', 'display_name' => '行政書士'
                    ]
                ]
            ],
            [
                'value' => 24, 'sort' => 24, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Local officials', 'display_name' => 'Local officials'],
                    [ 'label_name'=> 'Local officials', 'display_name' => '公務員'
                    ]
                ]
            ],
            [
                'value' => 25, 'sort' => 25, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Mass media and advertising', 'display_name' => 'Mass media and advertising'],
                    [ 'label_name'=> 'Mass media and advertising', 'display_name' => 'マスコミ・広告'
                    ]
                ]
            ],
            [
                'value' => 26, 'sort' => 26, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'creator', 'display_name' => 'creator'],
                    [ 'label_name'=> 'creator', 'display_name' => 'クリエイター'
                    ]
                ]
            ],
            [
                'value' => 27, 'sort' => 27, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'IT-related', 'display_name' => 'IT-related'],
                    [ 'label_name'=> 'IT-related', 'display_name' => 'IT関連'
                    ]
                ]
            ],
            [
                'value' => 28, 'sort' => 28, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Architecture and interior', 'display_name' => 'Architecture and interior'],
                    [ 'label_name'=> 'Architecture and interior', 'display_name' => '建築・インテリア'
                    ]
                ]
            ],
            [
                'value' => 29, 'sort' => 29, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Teachers and lecturers', 'display_name' => 'Teachers and lecturers'],
                    [ 'label_name'=> 'Teachers and lecturers', 'display_name' => '教師・講師'
                    ]
                ]
            ],
            [
                'value' => 30, 'sort' => 30, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'athlete', 'display_name' => 'athlete'],
                    [ 'label_name'=> 'athlete', 'display_name' => 'スポーツ選手'
                    ]
                ]
            ],
            [
                'value' => 31, 'sort' => 31, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Promotional model', 'display_name' => 'Promotional model'],
                    [ 'label_name'=> 'Promotional model', 'display_name' => 'イベントコンパニオン'
                    ]
                ]
            ],
            [
                'value' => 32, 'sort' => 32, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Acceptance', 'display_name' => 'Acceptance'],
                    [ 'label_name'=> 'Acceptance', 'display_name' => '受付'
                    ]
                ]
            ],
            [
                'value' => 33, 'sort' => 33, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Secretary', 'display_name' => 'Secretary'],
                    [ 'label_name'=> 'Secretary', 'display_name' => '秘書'
                    ]
                ]
            ],
            [
                'value' => 34, 'sort' => 34, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Apparel sales', 'display_name' => 'Apparel sales'],
                    [ 'label_name'=> 'Apparel sales', 'display_name' => 'アパレル・販売'
                    ]
                ]
            ],
            [
                'value' => 35, 'sort' => 35, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Estheticians', 'display_name' => 'Estheticians'],
                    [ 'label_name'=> 'Estheticians', 'display_name' => 'エステティシャン'
                    ]
                ]
            ],
            [
                'value' => 36, 'sort' => 36, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Hairdresser', 'display_name' => 'Hairdresser'],
                    [ 'label_name'=> 'Hairdresser', 'display_name' => '美容師'
                    ]
                ]
            ],
            [
                'value' => 37, 'sort' => 37, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'pharmacist', 'display_name' => 'pharmacist'],
                    [ 'label_name'=> 'pharmacist', 'display_name' => '薬剤師'
                    ]
                ]
            ],
            [
                'value' => 38, 'sort' => 38, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'nurse', 'display_name' => 'nurse'],
                    [ 'label_name'=> 'nurse', 'display_name' => '看護師'
                    ]
                ]
            ],
            [
                'value' => 39, 'sort' => 39, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Caregivers', 'display_name' => 'Caregivers'],
                    [ 'label_name'=> 'Caregivers', 'display_name' => '介護士'
                    ]
                ]
            ],
            [
                'value' => 40, 'sort' => 40, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Nutritionist, cook', 'display_name' => 'Nutritionist, cook'],
                    [ 'label_name'=> 'Nutritionist, cook', 'display_name' => '栄養士・調理師'
                    ]
                ]
            ],
            [
                'value' => 41, 'sort' => 41, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Childminder', 'display_name' => 'Childminder'],
                    [ 'label_name'=> 'Childminder', 'display_name' => '保育士'
                    ]
                ]
            ],
            [
                'value' => 42, 'sort' => 42, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'bridal', 'display_name' => 'bridal'],
                    [ 'label_name'=> 'bridal', 'display_name' => 'ブライダル'
                    ]
                ]
            ],
            [
                'value' => 43, 'sort' => 43, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Business', 'display_name' => 'Business'],
                    [ 'label_name'=> 'Business', 'display_name' => 'OL'
                    ]
                ]
            ],
            [
                'value' => 44, 'sort' => 44, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'employee', 'display_name' => 'employee'],
                    [ 'label_name'=> 'employee', 'display_name' => '会社員'
                    ]
                ]
            ],
            [
                'value' => 45, 'sort' => 45, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Student', 'display_name' => 'Student'],
                    [ 'label_name'=> 'Student', 'display_name' => '学生'
                    ]
                ]
            ],
			[
                'value' => 46, 'sort' => 46, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Professor / researcher', 'display_name' => 'Professor / researcher'],
                    [ 'label_name'=> 'Professor / researcher', 'display_name' => '教授/研究者'
                    ]
                ]
            ],
            [
                'value' => 47, 'sort' => 47, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Foreign consultants', 'display_name' => 'Foreign consultants'],
                    [ 'label_name'=> 'Foreign consultants', 'display_name' => '外資コンサル'
                    ]
                ]
            ],
            [
                'value' => 99, 'sort' => 99, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Otherwise', 'display_name' => 'Otherwise'],
                    [ 'label_name'=> 'Otherwise', 'display_name' => 'その他'
                    ]
                ]
            ]
        ]
    ];

    const preferred_job = [
        'neutral' => [
            [
                'value' => 0, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'I Don\'t Mind', 'display_name' => 'I Don\'t Mind'],
                    ['label_name' => 'I Don\'t Mind', 'display_name' => '気にしない']
                ]
            ]
        ],
        'Male' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name' => 'Nurse', 'display_name' => 'Nurse'],
                    ['label_name' => 'Nurse', 'display_name' => '看護師']
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Childminder', 'display_name' => 'Childminder'],
                    ['label_name' => 'Childminder', 'display_name' => '保育士']
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Flight Attendant', 'display_name' => 'Flight Attendant'],
                    ['label_name' => 'Flight Attendant', 'display_name' => 'CA']
                ]
            ],
            [
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'A Secretary', 'display_name' => 'A Secretary'],
                    ['label_name' => 'A Secretary', 'display_name' => '秘書']
                ]
            ],
            [
                'value' => 5, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Model', 'display_name' => 'Model'],
                    ['label_name' => 'Model', 'display_name' => 'モデル']
                ]
            ],
            [
                'value' => 6, 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Doctor', 'display_name' => 'Doctor'],
                    ['label_name' => 'Doctor', 'display_name' => '医者']
                ]
            ],
            [
                'value' => 7, 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Management', 'display_name' => 'Management'],
                    ['label_name' => 'Management', 'display_name' => '経営者']
                ]
            ],
            [
                'value' => 8, 'sort' => 8, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Hairdresser', 'display_name' => 'Hairdresser'],
                    ['label_name' => 'Hairdresser', 'display_name' => '美容師']
                ]
            ],
            [
                'value' => 9, 'sort' => 9, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Esthetic / Nailist', 'display_name' => 'Esthetic / Nailist'],
                    ['label_name' => 'Esthetic / Nailist', 'display_name' => 'ネイリスト/エステティシャン']
                ]
            ]
        ],
        'Female' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Doctor / Dentist', 'display_name' => 'Doctor / Dentist'],
                    ['label_name' => 'Doctor / Dentist', 'display_name' => '医者・歯科医師']
                ]
            ],
            [
                'value' => 2, 'status' => 1, 'sort' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Lawyer', 'display_name' => 'Lawyer'],
                    ['label_name' => 'Lawyer', 'display_name' => '弁護士']
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Accountant', 'display_name' => 'Accountant'],
                    ['label_name' => 'Accountant', 'display_name' => '会計士']
                ]
            ],
            [
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Management', 'display_name' => 'Management'],
                    ['label_name' => 'Management', 'display_name' => '経営者']
                ]
            ],
            [
                'value' => 5, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Merchant', 'display_name' => 'Merchant'],
                    ['label_name' => 'Merchant', 'display_name' => '商社']
                ]
            ],
            [
                'value' => 6, 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Bank', 'display_name' => 'Bank'],
                    ['label_name' => 'Bank', 'display_name' => '銀行']
                ]
            ],
            [
                'value' => 7, 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Civil Servant', 'display_name' => 'Civil Servant'],
                    ['label_name' => 'Civil Servant', 'display_name' => '公務員']
                ]
            ],
            [
                'value' => 8, 'sort' => 8, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Listed Company', 'display_name' => 'Listed Company'],
                    ['label_name' => 'Listed Company', 'display_name' => '上場企業']
                ]
            ],
            [
                'value' => 9, 'sort' => 9, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Model / Actor', 'display_name' => 'Model / Actor'],
                    ['label_name' => 'Model / Actor', 'display_name' => '色気']
                ]
            ]
        ]
    ];

    const hobby = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Fashion', 'display_name' => 'Fashion'],
                    [ 'label_name'=> 'Fashion', 'display_name' => 'ファッション'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Music - Musical Instrument', 'display_name' => 'Music - Musical Instrument'],
                    [ 'label_name'=> 'Music - Musical Instrument', 'display_name' => '音楽・楽器'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Photography / Camera', 'display_name' => 'Photography / Camera'],
                    [ 'label_name'=> 'Photography / Camera', 'display_name' => '写真・カメラ'
                    ]
                ]
            ],
            [
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Games · Manga', 'display_name' => 'Games · Manga'],
                    [ 'label_name'=> 'Games · Manga', 'display_name' => 'ゲーム・漫画'
                    ]
                ]
            ],
            [
                'value' => 5, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Movie / Drama', 'display_name' => 'Movie / Drama'],
                    [ 'label_name'=> 'Movie / Drama', 'display_name' => '映画・ドラマ'
                    ]
                ]
            ],
            [
                'value' => 6, 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Reading / Novel', 'display_name' => 'Reading / Novel'],
                    [ 'label_name'=> 'Reading / Novel', 'display_name' => '読書・小説'
                    ]
                ]
            ],
            [
                'value' => 7, 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Cuisine', 'display_name' => 'Cuisine'],
                    [ 'label_name'=> 'Cuisine', 'display_name' => '料理・お菓子作り'
                    ]
                ]
            ],
            [
                'value' => 8, 'sort' => 8, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Sweets', 'display_name' => 'Sweets'],
                    [ 'label_name'=> 'Sweets', 'display_name' => 'スイーツ'
                    ]
                ]
            ],
            [
                'value' => 9, 'sort' => 9, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Gourmet · Walking Eat', 'display_name' => 'Gourmet · Walking Eat'],
                    [ 'label_name'=> 'Gourmet · Walking Eat', 'display_name' => 'グルメ'
                    ]
                ]
            ],
            [
                'value' => 10, 'sort' => 10, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Karaoke', 'display_name' => 'Karaoke'],
                    [ 'label_name'=> 'Karaoke', 'display_name' => 'カラオケ'
                    ]
                ]
            ],
            [
                'value' => 11, 'sort' => 11, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Dart Billiards', 'display_name' => 'Dart Billiards'],
                    [ 'label_name'=> 'Dart Billiards', 'display_name' => 'ダーツ・ビリヤード'
                    ]
                ]
            ],
            [
                'value' => 12, 'sort' => 12, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Running', 'display_name' => 'Running'],
                    [ 'label_name'=> 'Running', 'display_name' => 'ランニング'
                    ]
                ]
            ],
            [
                'value' => 13, 'sort' => 13, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Cycling', 'display_name' => 'Cycling'],
                    [ 'label_name'=> 'Cycling', 'display_name' => 'サイクリング'
                    ]
                ]
            ],
            [
                'value' => 14, 'sort' => 14, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Car Drive', 'display_name' => 'Car Drive'],
                    [ 'label_name'=> 'Car Drive', 'display_name' => '車・ドライブ'
                    ]
                ]
            ],
            [
                'value' => 15, 'sort' => 15, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Golf', 'display_name' => 'Golf'],
                    [ 'label_name'=> 'Golf', 'display_name' => 'ゴルフ'
                    ]
                ]
            ],
            [
                'value' => 16, 'sort' => 16, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Watching Sports', 'display_name' => 'Watching Sports'],
                    [ 'label_name'=> 'Watching Sports', 'display_name' => 'スポーツ観戦'
                    ]
                ]
            ],
            [
                'value' => 17, 'sort' => 17, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Travel · Hot Spring', 'display_name' => 'Travel · Hot Spring'],
                    [ 'label_name'=> 'Travel · Hot Spring', 'display_name' => '旅行・温泉'
                    ]
                ]
            ],
            [
                'value' => 18, 'sort' => 18, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Overseas', 'display_name' => 'Overseas'],
                    [ 'label_name'=> 'Overseas', 'display_name' => '海外'
                    ]
                ]
            ],
            [
                'value' => 19, 'sort' => 19, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Sake', 'display_name' => 'Sake'],
                    [ 'label_name'=> 'Sake', 'display_name' => 'お酒'
                    ]
                ]
            ],
            [
                'value' => 20, 'sort' => 20, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'I Love Animals', 'display_name' => 'I Love Animals'],
                    [ 'label_name'=> 'I Love Animals', 'display_name' => '動物好き'
                    ]
                ]
            ],
            [
                'value' => 21, 'sort' => 21, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Cafe Visit', 'display_name' => 'Cafe Visit'],
                    [ 'label_name'=> 'Cafe Visit', 'display_name' => 'カフェ巡り'
                    ]
                ]
            ],
            [
                'value' => 22, 'sort' => 22, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Chilling At Home', 'display_name' => 'Chilling At Home'],
                    [ 'label_name'=> 'Chilling At Home', 'display_name' => '家でまったり'
                    ]
                ]
            ],
            [
                'value' => 23, 'sort' => 23, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Outdoor', 'display_name' => 'Outdoor'],
                    [ 'label_name'=> 'Outdoor', 'display_name' => 'アウトドア'
                    ]
                ]
            ],
            [
                'value' => 24, 'sort' => 24, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Surfing / Snowboarding', 'display_name' => 'Surfing / Snowboarding'],
                    [ 'label_name'=> 'Surfing / Snowboarding', 'display_name' => 'サーフィン・スノボ'
                    ]
                ]
            ],
            [
                'value' => 25, 'sort' => 25, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Interior · DIY', 'display_name' => 'Interior · DIY'],
                    [ 'label_name'=> 'Interior · DIY', 'display_name' => 'インテリア・DIY'
                    ]
                ]
            ],
            [
                'value' => 26, 'sort' => 26, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Museum / Art', 'display_name' => 'Museum / Art'],
                    [ 'label_name'=> 'Museum / Art', 'display_name' => '美術館・アート'
                    ]
                ]
            ],
			[
                'value' => 27, 'sort' => 27, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Camping', 'display_name' => 'Camping'],
                    [ 'label_name'=> 'Camping', 'display_name' => 'キャンプ'
                    ]
                ]
            ]
        ]
    ];

    const education_group = [
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'High School', 'display_name' => 'High School'],
                    [ 'label_name'=> 'High School', 'display_name' => '高卒'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Associate / Diploma', 'display_name' => 'Associate / Diploma'],
                    [ 'label_name'=> 'Associate / Diploma', 'display_name' => '短大/専門学校卒'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Less Famous Uni', 'display_name' => 'Less Famous Uni'],
                    [ 'label_name'=> 'Less Famous Uni', 'display_name' => '無名大/地方県立/短大'
                    ]
                ]
            ],
            [
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Medium Standard Uni', 'display_name' => 'Medium Standard Uni'],
                    [ 'label_name'=> 'Medium Standard Uni', 'display_name' => '日東駒専その他有名一般大'
                    ]
                ]
            ],
            [
                'value' => 5, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Famous Uni', 'display_name' => 'Famous Uni'],
                    [ 'label_name'=> 'Famous Uni', 'display_name' => '国立MARCH関関同立'
                    ]
                ]
            ],
            [
                'value' => 6, 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'More Famous Uni', 'display_name' => 'More Famous Uni'],
                    [ 'label_name'=> 'More Famous Uni', 'display_name' => '東京早慶一工阪 / 海外有名/医学部'
                    ]
                ]
            ]
        ]
    ];

    const preferred_importance_of_looks = [
        'neutral' => [
            [
                'value' => 0, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Personality Is Much More Important', 'display_name' => 'Personality Is Much More Important'],
                    [ 'label_name'=> 'Personality Is Much More Important', 'display_name' => '外見よりも内面重視'
                    ]
                ]
            ],
            [
                'value' => 1, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Personality Is More Important', 'display_name' => 'Personality Is More Important'],
                    [ 'label_name'=> 'Personality Is More Important', 'display_name' => 'どちらかというと内面重視'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Looks Is More Important', 'display_name' => 'Looks Is More Important'],
                    [ 'label_name'=> 'Looks Is More Important', 'display_name' => 'どちらかというと外見重視'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Looks Is Much More Important', 'display_name' => 'Looks Is Much More Important'],
                    [ 'label_name'=> 'Looks Is Much More Important', 'display_name' => '内面よりも外見重視'
                    ]
                ]
            ]
        ]
    ];

    const preferred_character = [
        'Male' => [
            [
                'value' => 16, 'sort' => 16, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Elegant', 'display_name' => 'Elegant'],
                    [ 'label_name'=> 'Elegant', 'display_name' => '上品'
                    ]
                ]
            ],
            [
                'value' => 17, 'sort' => 17, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Lonely', 'display_name' => 'Lonely'],
                    [ 'label_name'=> 'Lonely', 'display_name' => '寂しがり'
                    ]
                ]
            ],
            [
                'value' => 18, 'sort' => 18, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Shy', 'display_name' => 'Shy'],
                    [ 'label_name'=> 'Shy', 'display_name' => '奥手'
                    ]
                ]
            ],
            [
                'value' => 19, 'sort' => 19, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Independent', 'display_name' => 'Independent'],
                    [ 'label_name'=> 'Independent', 'display_name' => '自立している'
                    ]
                ]
            ],
            [
                'value' => 20, 'sort' => 20, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Goofy', 'display_name' => 'Goofy'],
                    [ 'label_name'=> 'Goofy', 'display_name' => '天然'
                    ]
                ]
            ]
        ],
        'Female' => [
            [
                'value' => 6, 'sort' => 6, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Decisive', 'display_name' => 'Decisive'],
                    [ 'label_name'=> 'Decisive', 'display_name' => '決断力がある'
                    ]
                ]
            ],
            [
                'value' => 9, 'sort' => 9, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Passionate', 'display_name' => 'Passionate'],
                    [ 'label_name'=> 'Passionate', 'display_name' => '情熱的'
                    ]
                ]
            ],
            [
                'value' => 11, 'sort' => 11, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Generous', 'display_name' => 'Generous'],
                    [ 'label_name'=> 'Generous', 'display_name' => '気前がいい'
                    ]
                ]
            ],
            [
                'value' => 12, 'sort' => 12, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Homely', 'display_name' => 'Homely'],
                    [ 'label_name'=> 'Homely', 'display_name' => '家庭的'
                    ]
                ]
            ],
            [
                'value' => 13, 'sort' => 13, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Job Lover', 'display_name' => 'Job Lover'],
                    [ 'label_name'=> 'Job Lover', 'display_name' => '仕事好き'
                    ]
                ]
            ],
            [
                'value' => 14, 'sort' => 14, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Curious', 'display_name' => 'Curious'],
                    [ 'label_name'=> 'Curious', 'display_name' => '好奇心旺盛'
                    ]
                ]
            ],
            [
                'value' => 15, 'sort' => 15, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Good Listener', 'display_name' => 'Good Listener'],
                    [ 'label_name'=> 'Good Listener', 'display_name' => '聞き上手'
                    ]
                ]
            ]
        ],
        'neutral' => [
            [
                'value' => 1, 'sort' => 1, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'kind', 'display_name' => 'kind'],
                    [ 'label_name'=> 'kind', 'display_name' => '優しい'
                    ]
                ]
            ],
            [
                'value' => 2, 'sort' => 2, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Funny', 'display_name' => 'Funny'],
                    [ 'label_name'=> 'Funny', 'display_name' => '面白い'
                    ]
                ]
            ],
            [
                'value' => 3, 'sort' => 3, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Happy', 'display_name' => 'Happy'],
                    [ 'label_name'=> 'Happy', 'display_name' => '明るい'
                    ]
                ]
            ],
            [
                'value' => 4, 'sort' => 4, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Intelligent', 'display_name' => 'Intelligent'],
                    [ 'label_name'=> 'Intelligent', 'display_name' => '知的'
                    ]
                ]
            ],
            [
                'value' => 5, 'sort' => 5, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Sincere', 'display_name' => 'Sincere'],
                    [ 'label_name'=> 'Sincere', 'display_name' => '誠実'
                    ]
                ]
            ],
            [
                'value' => 7, 'sort' => 7, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Helpful', 'display_name' => 'Helpful'],
                    [ 'label_name'=> 'Helpful', 'display_name' => '面倒見が良い'
                    ]
                ]
            ],
            [
                'value' => 8, 'sort' => 8, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Calm', 'display_name' => 'Calm'],
                    [ 'label_name'=> 'Calm', 'display_name' => '落ち着いている'
                    ]
                ]
            ],
            [
                'value' => 10, 'sort' => 10, 'status' => 1,
                'register_options_translations' => [
                    [ 'label_name'=> 'Caring', 'display_name' => 'Caring'],
                    [ 'label_name'=> 'Caring', 'display_name' => '気がきく'
                    ]
                ]
            ]
        ],
    ];

    const profile_height = [
        'Male' => [
            ['value' => 159, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '159 cm', 'display_name' => '159 cm'],
                    ['label_name' => '159 cm', 'display_name' => '159 cm']
                ]
            ],
            ['value' => 160, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '160 cm', 'display_name' => '160 cm'],
                    ['label_name' => '160 cm', 'display_name' => '160 cm']
                ]
            ],
            ['value' => 161, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '161 cm', 'display_name' => '161 cm'],
                    ['label_name' => '161 cm', 'display_name' => '161 cm']
                ]
            ],
            ['value' => 162, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '160 cm', 'display_name' => '162 cm'],
                    ['label_name' => '160 cm', 'display_name' => '162 cm']
                ]
            ],
            ['value' => 163, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '163 cm', 'display_name' => '163 cm'],
                    ['label_name' => '163 cm', 'display_name' => '163 cm']
                ]
            ],
            ['value' => 164, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '164 cm', 'display_name' => '164 cm'],
                    ['label_name' => '164 cm', 'display_name' => '164 cm']
                ]
            ],
            ['value' => 165, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '165 cm', 'display_name' => '165 cm'],
                    ['label_name' => '165 cm', 'display_name' => '165 cm']
                ]
            ],
            ['value' => 166, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '166 cm', 'display_name' => '166 cm'],
                    ['label_name' => '166 cm', 'display_name' => '166 cm']
                ]
            ],
            ['value' => 167, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '167 cm', 'display_name' => '167 cm'],
                    ['label_name' => '167 cm', 'display_name' => '167 cm']
                ]
            ],
            ['value' => 168, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '168 cm', 'display_name' => '168 cm'],
                    ['label_name' => '168 cm', 'display_name' => '168 cm']
                ]
            ],
            ['value' => 169, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '169 cm', 'display_name' => '169 cm'],
                    ['label_name' => '169 cm', 'display_name' => '169 cm']
                ]
            ],
            ['value' => 170, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '170 cm', 'display_name' => '170 cm'],
                    ['label_name' => '170 cm', 'display_name' => '170 cm']
                ]
            ],
            ['value' => 171, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '171 cm', 'display_name' => '171 cm'],
                    ['label_name' => '171 cm', 'display_name' => '171 cm']
                ]
            ],
            ['value' => 172, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '172 cm', 'display_name' => '172 cm'],
                    ['label_name' => '172 cm', 'display_name' => '172 cm']
                ]
            ],
            ['value' => 173, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '173 cm', 'display_name' => '173 cm'],
                    ['label_name' => '173 cm', 'display_name' => '173 cm']
                ]
            ],
            ['value' => 174, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '174 cm', 'display_name' => '174 cm'],
                    ['label_name' => '174 cm', 'display_name' => '174 cm']
                ]
            ],
            ['value' => 175, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '175 cm', 'display_name' => '175 cm'],
                    ['label_name' => '175 cm', 'display_name' => '175 cm']
                ]
            ],
            ['value' => 176, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '176 cm', 'display_name' => '176 cm'],
                    ['label_name' => '176 cm', 'display_name' => '176 cm']
                ]
            ],
            ['value' => 177, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '177 cm', 'display_name' => '177 cm'],
                    ['label_name' => '177 cm', 'display_name' => '177 cm']
                ]
            ],
            ['value' => 178, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '178 cm', 'display_name' => '178 cm'],
                    ['label_name' => '178 cm', 'display_name' => '178 cm']
                ]
            ],
            ['value' => 179, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '179 cm', 'display_name' => '179 cm'],
                    ['label_name' => '179 cm', 'display_name' => '179 cm']
                ]
            ],
            ['value' => 180, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '180 cm', 'display_name' => '180 cm'],
                    ['label_name' => '180 cm', 'display_name' => '180 cm']
                ]
            ],
            ['value' => 181, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '181 cm', 'display_name' => '181 cm'],
                    ['label_name' => '181 cm', 'display_name' => '181 cm']
                ]
            ],
            ['value' => 182, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '182 cm', 'display_name' => '182 cm'],
                    ['label_name' => '182 cm', 'display_name' => '182 cm']
                ]
            ],
            ['value' => 183, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '183 cm', 'display_name' => '183 cm'],
                    ['label_name' => '183 cm', 'display_name' => '183 cm']
                ]
            ],
            ['value' => 184, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '184 cm', 'display_name' => '184 cm'],
                    ['label_name' => '184 cm', 'display_name' => '184 cm']
                ]
            ],
            ['value' => 185, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '185 cm', 'display_name' => '185 cm'],
                    ['label_name' => '185 cm', 'display_name' => '185 cm']
                ]
            ],
            ['value' => 186, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '186 cm', 'display_name' => '186 cm'],
                    ['label_name' => '186 cm', 'display_name' => '186 cm']
                ]
            ],
            ['value' => 187, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '187 cm', 'display_name' => '187 cm'],
                    ['label_name' => '187 cm', 'display_name' => '187 cm']
                ]
            ],
            ['value' => 188, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '188 cm', 'display_name' => '188 cm'],
                    ['label_name' => '188 cm', 'display_name' => '188 cm']
                ]
            ],
            ['value' => 189, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '189 cm', 'display_name' => '189 cm'],
                    ['label_name' => '189 cm', 'display_name' => '189 cm']
                ]
            ],
            ['value' => 190, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '190 cm', 'display_name' => '190 cm'],
                    ['label_name' => '190 cm', 'display_name' => '190 cm']
                ]
            ],
            ['value' => 191, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '191 cm', 'display_name' => '191 cm'],
                    ['label_name' => '191 cm', 'display_name' => '191 cm']
                ]
            ],
        ],
        'Female' => [
            ['value' => 149, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '149 cm', 'display_name' => '149 cm'],
                    ['label_name' => '149 cm', 'display_name' => '149 cm']
                ]
            ],
            ['value' => 150, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '150 cm', 'display_name' => '150 cm'],
                    ['label_name' => '150 cm', 'display_name' => '150 cm']
                ]
            ],
            ['value' => 151, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '151 cm', 'display_name' => '151 cm'],
                    ['label_name' => '151 cm', 'display_name' => '151 cm']
                ]
            ],
            ['value' => 152, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '152 cm', 'display_name' => '152 cm'],
                    ['label_name' => '152 cm', 'display_name' => '152 cm']
                ]
            ],
            ['value' => 153, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '153 cm', 'display_name' => '153 cm'],
                    ['label_name' => '153 cm', 'display_name' => '153 cm']
                ]
            ],
            ['value' => 154, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '154 cm', 'display_name' => '154 cm'],
                    ['label_name' => '154 cm', 'display_name' => '154 cm']
                ]
            ],
            ['value' => 155, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '155 cm', 'display_name' => '155 cm'],
                    ['label_name' => '155 cm', 'display_name' => '155 cm']
                ]
            ],
            ['value' => 156, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '156 cm', 'display_name' => '156 cm'],
                    ['label_name' => '156 cm', 'display_name' => '156 cm']
                ]
            ],
            ['value' => 157, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '157 cm', 'display_name' => '157 cm'],
                    ['label_name' => '157 cm', 'display_name' => '157 cm']
                ]
            ],
            ['value' => 158, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '158 cm', 'display_name' => '158 cm'],
                    ['label_name' => '158 cm', 'display_name' => '158 cm']
                ]
            ],
            ['value' => 159, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '159 cm', 'display_name' => '159 cm'],
                    ['label_name' => '159 cm', 'display_name' => '159 cm']
                ]
            ],
            ['value' => 160, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '160 cm', 'display_name' => '160 cm'],
                    ['label_name' => '160 cm', 'display_name' => '160 cm']
                ]
            ],
            ['value' => 161, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '161 cm', 'display_name' => '161 cm'],
                    ['label_name' => '161 cm', 'display_name' => '161 cm']
                ]
            ],
            ['value' => 162, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '160 cm', 'display_name' => '162 cm'],
                    ['label_name' => '160 cm', 'display_name' => '162 cm']
                ]
            ],
            ['value' => 163, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '163 cm', 'display_name' => '163 cm'],
                    ['label_name' => '163 cm', 'display_name' => '163 cm']
                ]
            ],
            ['value' => 164, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '164 cm', 'display_name' => '164 cm'],
                    ['label_name' => '164 cm', 'display_name' => '164 cm']
                ]
            ],
            ['value' => 165, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '165 cm', 'display_name' => '165 cm'],
                    ['label_name' => '165 cm', 'display_name' => '165 cm']
                ]
            ],
            ['value' => 166, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '166 cm', 'display_name' => '166 cm'],
                    ['label_name' => '166 cm', 'display_name' => '166 cm']
                ]
            ],
            ['value' => 167, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '167 cm', 'display_name' => '167 cm'],
                    ['label_name' => '167 cm', 'display_name' => '167 cm']
                ]
            ],
            ['value' => 168, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '168 cm', 'display_name' => '168 cm'],
                    ['label_name' => '168 cm', 'display_name' => '168 cm']
                ]
            ],
            ['value' => 169, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '169 cm', 'display_name' => '169 cm'],
                    ['label_name' => '169 cm', 'display_name' => '169 cm']
                ]
            ],
            ['value' => 170, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '170 cm', 'display_name' => '170 cm'],
                    ['label_name' => '170 cm', 'display_name' => '170 cm']
                ]
            ],
            ['value' => 171, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '171 cm', 'display_name' => '171 cm'],
                    ['label_name' => '171 cm', 'display_name' => '171 cm']
                ]
            ],
            ['value' => 172, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '172 cm', 'display_name' => '172 cm'],
                    ['label_name' => '172 cm', 'display_name' => '172 cm']
                ]
            ],
            ['value' => 173, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '173 cm', 'display_name' => '173 cm'],
                    ['label_name' => '173 cm', 'display_name' => '173 cm']
                ]
            ],
            ['value' => 174, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '174 cm', 'display_name' => '174 cm'],
                    ['label_name' => '174 cm', 'display_name' => '174 cm']
                ]
            ],
            ['value' => 175, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '175 cm', 'display_name' => '175 cm'],
                    ['label_name' => '175 cm', 'display_name' => '175 cm']
                ]
            ],
            ['value' => 176, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '176 cm', 'display_name' => '176 cm'],
                    ['label_name' => '176 cm', 'display_name' => '176 cm']
                ]
            ],
            ['value' => 177, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '177 cm', 'display_name' => '177 cm'],
                    ['label_name' => '177 cm', 'display_name' => '177 cm']
                ]
            ],
            ['value' => 178, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '178 cm', 'display_name' => '178 cm'],
                    ['label_name' => '178 cm', 'display_name' => '178 cm']
                ]
            ],
            ['value' => 179, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '179 cm', 'display_name' => '179 cm'],
                    ['label_name' => '179 cm', 'display_name' => '179 cm']
                ]
            ],
            ['value' => 180, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '180 cm', 'display_name' => '180 cm'],
                    ['label_name' => '180 cm', 'display_name' => '180 cm']
                ]
            ],
            ['value' => 181, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => '181 cm', 'display_name' => '181 cm'],
                    ['label_name' => '181 cm', 'display_name' => '181 cm']
                ]
            ],
        ]
    ];

    const profile_body_type =[
        'Male' => [
            ['value' => 1, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Skinny', 'display_name' => 'Skinny'],
                    ['label_name' => 'スリム', 'display_name' => 'スリム']
                ]
            ],
            ['value' => 2, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Skinny Fit', 'display_name' => 'Skinny Fit'],
                    ['label_name' => 'やや細め', 'display_name' => 'やや細め']
                ]
            ],
            ['value' => 3, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Fit', 'display_name' => 'Fit'],
                    ['label_name' => '普通', 'display_name' => '普通']
                ]
            ],
            ['value' => 4, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Curvy', 'display_name' => 'Curvy'],
                    ['label_name' => '筋肉質', 'display_name' => '筋肉質']
                ]
            ],
            ['value' => 5, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Chubby', 'display_name' => 'Chubby'],
                    ['label_name' => 'ややぽっちゃり', 'display_name' => 'ややぽっちゃり']
                ]
            ],
        ],
        'Female' => [
            ['value' => 1, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Skinny', 'display_name' => 'Skinny'],
                    ['label_name' => 'スリム', 'display_name' => 'スリム']
                ]
            ],
            ['value' => 2, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Skinny Fit', 'display_name' => 'Skinny Fit'],
                    ['label_name' => 'やや細め', 'display_name' => 'やや細め']
                ]
            ],
            ['value' => 3, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Fit', 'display_name' => 'Fit'],
                    ['label_name' => '普通', 'display_name' => '普通']
                ]
            ],
            ['value' => 4, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Curvy', 'display_name' => 'Curvy'],
                    ['label_name' => 'グラマー', 'display_name' => 'グラマー']
                ]
            ],
            ['value' => 5, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Chubby', 'display_name' => 'Chubby'],
                    ['label_name' => 'ややぽっちゃり', 'display_name' => 'ややぽっちゃり']
                ]
            ],
        ]
    ];

    const strengths_of_appearance = [
        'Male' => [
            ['value' => 1, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Eyes', 'display_name' => 'Beautiful Eyes'],
                    ['label_name' => 'ぱっちりした目', 'display_name' => 'ぱっちりした目']
                ]
            ],
            ['value' => 2, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Nose', 'display_name' => 'Beautiful Nose'],
                    ['label_name' => '鼻筋', 'display_name' => '鼻筋']
                ]
            ],
            ['value' => 3, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Smile', 'display_name' => 'Beautiful Smile'],
                    ['label_name' => '笑顔', 'display_name' => '笑顔']
                ]
            ],
            ['value' => 4, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Face Shape', 'display_name' => 'Beautiful Face Shape'],
                    ['label_name' => '小顔', 'display_name' => '小顔']
                ]
            ],
            ['value' => 7, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Short Hair', 'display_name' => 'Short Hair'],
                    ['label_name' => '短髪', 'display_name' => '短髪']
                ]
            ],
            ['value' => 8, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Black Hair', 'display_name' => 'Black Hair'],
                    ['label_name' => '黒髪', 'display_name' => '黒髪']
                ]
            ],
            ['value' => 9, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Teeth', 'display_name' => 'Beautiful Teeth'],
                    ['label_name' => '歯並び', 'display_name' => '歯並び']
                ]
            ],
            ['value' => 10, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Single Eyelids', 'display_name' => 'Single Eyelids'],
                    ['label_name' => '一重', 'display_name' => '一重']
                ]
            ],
            ['value' => 11, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Smile Lines', 'display_name' => 'Smile Lines'],
                    ['label_name' => '笑いジワ', 'display_name' => '笑いジワ']
                ]
            ],
            ['value' => 12, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Voluptuous / Hunky', 'display_name' => 'Voluptuous / Hunky'],
                    ['label_name' => '筋肉質', 'display_name' => '筋肉質']
                ]
            ],
            ['value' => 15, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Skin', 'display_name' => 'Beautiful Skin'],
                    ['label_name' => '肌', 'display_name' => '肌']
                ]
            ],
            ['value' => 16, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Sexy', 'display_name' => 'Sexy'],
                    ['label_name' => '色気', 'display_name' => '色気']
                ]
            ],

        ],
        'Female' => [
            ['value' => 1, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Eyes', 'display_name' => 'Beautiful Eyes'],
                    ['label_name' => 'ぱっちりした目', 'display_name' => 'ぱっちりした目']
                ]
            ],
            ['value' => 2, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Nose', 'display_name' => 'Beautiful Nose'],
                    ['label_name' => '鼻筋', 'display_name' => '鼻筋']
                ]
            ],
            ['value' => 3, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Smile', 'display_name' => 'Beautiful Smile'],
                    ['label_name' => '笑顔', 'display_name' => '笑顔']
                ]
            ],
            ['value' => 4, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Face Shape', 'display_name' => 'Beautiful Face Shape'],
                    ['label_name' => '小顔', 'display_name' => '小顔']
                ]
            ],
            ['value' => 5, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Rounded Face', 'display_name' => 'Rounded Face'],
                    ['label_name' => '丸顔', 'display_name' => '丸顔']
                ]
            ],
            ['value' => 6, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Long Hair', 'display_name' => 'Long Hair'],
                    ['label_name' => 'ロングヘア', 'display_name' => 'ロングヘア']
                ]
            ],
            ['value' => 7, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Short Hair', 'display_name' => 'Short Hair'],
                    ['label_name' => 'ショートヘア', 'display_name' => 'ショートヘア']
                ]
            ],
            ['value' => 8, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Black Hair', 'display_name' => 'Black Hair'],
                    ['label_name' => '黒髪', 'display_name' => '黒髪']
                ]
            ],
            ['value' => 9, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Teeth', 'display_name' => 'Beautiful Teeth'],
                    ['label_name' => '歯並び', 'display_name' => '歯並び']
                ]
            ],
            ['value' => 13, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Dimple', 'display_name' => 'Dimple'],
                    ['label_name' => 'えくぼ', 'display_name' => 'えくぼ']
                ]
            ],
            ['value' => 14, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'White Skin', 'display_name' => 'White Skin'],
                    ['label_name' => '色白', 'display_name' => '色白']
                ]
            ],
            ['value' => 15, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Beautiful Skin', 'display_name' => 'Beautiful Skin'],
                    ['label_name' => '肌', 'display_name' => '肌']
                ]
            ],
            ['value' => 16, 'sort' => 0, 'status' => 1,
                'register_options_translations' => [
                    ['label_name' => 'Sexy', 'display_name' => 'Sexy'],
                    ['label_name' => '色気', 'display_name' => '色気']
                ]
            ],

        ]
    ];

}
