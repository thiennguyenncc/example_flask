<?php

return [
    // SMS
    'sms_title_media' => 'bachelora',
    'verification_code_context' => 'バチェラーデート 認証コード: :auth_code' . PHP_EOL . '有効期限は:expiry_minutes分です。',
    'verification_code_timeout' => 10,
    'auto_login_code' => '_autologin4233',

    // Authentication
    'new_line_login' => 'new-line-login',
    'line_login' => 'line-login',
    'app_line_login' => 'app-line-login',
    'app_login' => 'app-login',
    'add_line_to_facebook' => 'add-line-to-facebook',
    // Dating places
    'number_of_train_stations' => 1,
    'dating_place_storage_path' => 'attachments/cafe_pic/',

    'cancel_charge_not_free_day' => 2000,
    'cancel_charge_on_date_day' => 3000,
    'cancel_charge_for_partner_did_not_show_up' => 6000,
    'currency_symbol' => '円',
    'default_bachelor_rate' => 3,

    // Match Profile
    'displayable_weeks' => 3,
    'border_of_b_rate_to_show_crown' => 3.0,

    // Cafe storage path
    'cafe_storage_path' => 'attachments/user_images/',

    // Match profile images
    'match_profile_storage_path' => 'match_profile_pic/',
    'user_profile_storage_path' => 'user_profile_pic/',

    'default_dating_time_string' => [
        'en' => 'evening',
        'ja' => '夕方'
    ],

    // Feedback
    'calc_fb_num_per_report' => 4,
    'report_generate_frequency_fb' => 2,
    'rating_max' => 5,
    'limit_rating_user_condition' => 2,
    'limit_point_condition' => 5,
    'default_average_point' => 6,
    'limit_show_review_box' => 3,
    'limit_star_category' => 3,

    'FEEDBACK_URL' => env('WEB_APP_URL') . "feedback?openExternalBrowser=1&dating_id=",
    'CHAT_URL' => env('WEB_APP_URL') . "chat/room/",

    'currency' => [
        'ja' => 'jpy',
        'en' => 'usd',
    ],

    'boundary_age_for_age_setting_for_male' => 40,

    //bulk approval
    'boundary_of_high_team_member_rate' => 7,
    'default_b_rate_for_high_rated_female' => 4,
];
