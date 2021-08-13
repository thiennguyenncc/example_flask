<?php

return [
    'successful' => 'Successful',
    'prefecture' => [
        'not_found' => '大エリアが見つかりませんでした',
        'unable_to_create_prefecture' => '大エリアの追加に失敗しました',
        'successfully_created_new_prefecture' => '大エリアを追加しました',
        'unable_to_update_prefecture' => '大エリアの更新に失敗しました',
        'successfully_updated_prefecture' => '大エリアを更新しました',
        'prefecture_in_use' => '大エリアは使用されています',
    ],
    'area' => [
        'not_found' => 'エリアが見つかりませんでした',
        'unable_to_create_area' => 'デートエリアを追加できませんでした',
        'successfully_created_new_area' => 'デートエリアを追加しました',
        'unable_to_update_area' => 'デートエリアを更新できませんでした',
        'successfully_updated_area' => 'デートエリアを更新しました',
        'successfully_deleted_area' => 'デートエリアを削除しました',
    ],
    'datingPlace' => [
        'unable_to_create_dating_place' => 'デート場所を追加できませんでした',
        'successfully_created_new_dating_place' => 'デート場所を追加しました',
        'unable_to_update_dating_place' => 'デート場所を更新できませんでした',
        'successfully_updated_dating_place' => 'デート場所を更新しました',
        'successfully_deleted_dating_place' => 'デート場所を削除しました',
        'unable_to_find_train_station' => 'デート場所が見つかりませんでした :datingPlaceName',
    ],
    'paymentCard' => [
        'successfully_list_user_cards' => 'カードの取得に成功しました',
        'error_year_required' => '年を選択してください',
        'error_month_required' => '月を選択してください',
        'error_require_date' => '日を選択してください',
    ],
    'stripe_api' => [
        'cancellation_fee_invoice_item_description' => [
            'en' => ':dating_date CANCELLATION FEE',
            'ja' => ':dating_date キャンセル料'
        ],
        'cancellation_fee_invoice_memo' => [
            'en' => 'We are currently only accepting inquiries through our support site.',
            'ja' => '※現在、お問い合わせはサポートサイトからのみ受け付けております。'
        ],
    ],
    'userReview' => [
        'successfully_created_new_user_review' => 'AI学習シートの登録に成功しました',
    ],
    'userCoupon' => [
        'coupon_type_doesn\'t_exist' => 'チケットタイプが無効です',
        'no_user_coupon_found' => 'チケットが見つかりませんでした',
        'not_enough_coupon_to_exchange' => 'チケット枚数が足りません',
        'no_coupons_found_for_the_user' => 'チケットが見つかりませんでした',
        'unable_to_issue_dating_coupon_to_female_user' => '女性には振替チケットを発行できません',
        'unable_to_purchase_dating_coupon_to_female_user' => '女性は振替チケットを購入できません',
        'coupon_return_text' => 'チケットを利用しての参加だったため、本日21時ごろ返却されます。',
    ],
    'dating' => [
        'no_dating_found' => 'デートが見つかりませんでした',
        'this_dating_has_already_been_completed' => 'このデートはすでに完了しています',
        'failed_to_get_dating_user' => 'ユーザーのデートが見つかりませんでした',
        'failed_to_get_dating_partner' => 'パートナーのデータが見つかりませんでした',
        'dating_male_user_already_exist_dating_in_this_dating_day' => '男性がすでに同じ日程に参加しています\n別日程を選択してください',
        'dating_female_user_already_exist_dating_in_this_dating_day' => "女性がすでに同じ日程に参加しています\n別日程を選択してください",
        'dating_male_and_female_user_already_exist_dating_in_this_dating_day' => "男性、女性どちらもすでに同じ日程に参加しています\n別日程を選択してください"
    ],
    'user' => [
        'problem_encountered_while_migrating_account' => "アカウントの移行中にエラーが発生しました。\n移行先ID :migrating_to_user_id →　移行元ID :migrating_from_user_id",
        'successfully_updated_email' => 'メールアドレスが正常に更新されました',
        'email_update_failed' => 'メールアドレスの更新に失敗しました',
        'invalid_status' => 'ステータスが無効です',
    ],
    'registration' => [
        'error_prefecture_required' => 'エリアを選択してください。',
        'error_user_name_required' => "名前を入力してください\n(公開されることはありません)",
        'min_age_is_required' => '年齢の下限を入力してください',
        'max_age_is_required' => '年齢の上限を入力してください',
        'min_height_is_required' => '身長の下限を入力してください',
        'max_height_is_required' => '身長の上限を入力してください',
        'face_preferences_is_required' => '好みの顔の特徴を入力してください',
        'job_is_required' => '職業を入力してださい',
        'bodyType1_is_required' => '好みの体型を入力してください',
        'bodyType2_is_required' => '好みの体型を入力してください',
        'preferred_education_is_required' => '学歴条件を入力してください',
        'alcohol_is_required' => '飲酒タイプを入力してください',
        'divorce_is_required' => '離婚歴を入力してください',
        'annual_income_is_required' => '年収を入力してください',
        'company_name_is_required' => '企業名を入力してください',
        'education_is_required' => '卒業タイプを選択してください',
        'school_name_is_required' => '学校名を選択してください',
        'smoking_is_required' => '喫煙タイプを選択してください',
        'images_is_required' => "写真を登録してください\n(公開されることはありません)",
        'error_require_email' => 'メールアドレスを入力してください',
        'error_exists_email' => 'このメールアドレスは既に使われています',
        'error_invalid_email' => '有効なメールアドレスを入力してください',
        'error_while_storing_registration_data' => 'ステップ :step の情報を取得できませんでした',
        'height_is_required' => '身長を選択してください',
        'body_type_is_required' => '体型を選択してください',
        'appearance_strength_is_required' => '顔の特徴を選択してください',
        'character_is_required' => '性格を選択してください',
        'hobby_is_required' => '趣味を選択してください',
        'willingness_for_marriage_is_required' => '結婚に対する意思を選択してください',
        'important_preferences_is_required' => '重要条件を選択してください',
        'importance_of_look_value_is_required' => '容姿の重要度を選択してください',
        'user_preferred_areas_is_required' => '希望デートエリアを選択してください',
    ],
    'matched_preference' => [
        'greaduated_from' => [
            1 => ':school 卒業の方です。',
            2 => ':school 卒業の方です。',
        ],
        'no_history_divorce' => [
            1 => '離婚歴が、「無し」の方です。',
            2 => '離婚歴が、「無し」の方です。',
        ],
        'age_is' => [
            1 => "年齢が、「:age歳」の方です。",
            2 => "年齢が、「:age歳」の方です。",
        ],
        'height_is' => [
            1 => "身長が、「:height cm」の方です。",
            2 => "身長が、「:height cm」の方です。",
        ],
        'character_are' => [
            1 => "性格が、「:character」の方です。",
            2 => "性格が、「:character」の方です。",
        ],
        'body_shape_is' => [
            1 => "体型が、 「:body_shape」の方です。",
            2 => "体型が、「:body_shape」の方です。",
        ],
        'dont_smoke' => [
            1 => 'タバコを、「吸わない」方です。',
            2 => 'タバコを、「吸わない」方です。',
        ],
        'alcohol_preference_is' => [
            1 => "お酒を、「:drink」方です。",
            2 => "お酒を、「:drink」方です。",
        ],
        'marriage_intention_preference_is' => [
            1 => "結婚に対する意思が、「:merriage」方です。",
            2 => "結婚に対する意思が、「:merriage」方です。",
        ],
        'hobby_preference_is' => [
            1 => "趣味が、「:hobby」の方です。",
            2 => "趣味が、「:hobby」の方です。",
        ],
        'face_preference_is' => [
            1 => "顔の特徴が、「:face_preference」の方です。",
            2 => "顔の特徴が、「:face_preference」の方です。",
        ],
        'educational_background_is_medium_standard_uni' => [
            1 => '学歴が、「高学歴」の方です。',
            2 => '学歴が、「高学歴」の方です。',
        ],
        'educational_background_is_highly_educated' => [
            1 => '学歴が、「有名大学卒」の方です。',
            2 => '学歴が、「有名大学卒」の方です。',
        ],
        'annual_income_is' => [
            1 => "年収が、「:partnerIncome」の方です。",
            2 => "年収が、「:partnerIncome」の方です。",
        ],
    ],
    'femaleProfilePageStatus' => [
        'approved' => '合格済',
        'pre-approved' => '仮合格',
        'deactivated' => '休会中',
    ],
    'femaleParticipateRematch' => [
        'female_participate_rematch_failure' => '12時のマッチングに参加できません。'
    ],
    'did_you_use_cafe' => 'お近くには、次の公園があります。',
    'also_next_cafe_near' => 'お近くには、次のカフェがあります。',
    'ask_current_cafe' => 'が使えませんでしたか？',
    'exception' => [
        'uncompatible_for_popup_validation' => 'ポップアップエラーの形式に沿っていません'
    ],
    'feedback' => [
        'cant_send_feedback' => 'AI学習シートが送信できませんでした',
    ],
    'invoice' => [
        'failed_to_create_invoice' => 'キャンセル料の請求に失敗しました',
    ],
    'cancel_deactivate_account' => [
        'cant_deactivate_account' => '休会できません。事務局にお問い合わせください。',
        'cant_cancel_account' => '退会できません。事務局にお問い合わせください。',
        'you_have_to_cancel_participation' => 'デート参加がまだ残っています',
        'you_have_to_cancel_participation_for_rematch' => "お相手探し中のデートが\n残っています",
        'you_have_to_cancel_dating' => "休会/退会前に、デートを\nキャンセルしてください。",
        'you_have_to_give_feedback' => '未記入のフィードバックがあります。',
    ]
];
