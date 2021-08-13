<?php
return [
    /********** START REGISTRATION & APPROVAL ***********/

    [
        "key" => "complete_1st_registation_male",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "male complete first registraion ",
        "content" => "バチェラーデートにご登録ありがとうございます！\n 合格者には3日以内にEメールにて通知させていただきます！? \n\n ※ 以前ご利用したことがあり、デートを体験済の方は正規会員として再開されます。\n ※ 審査期間中は一切料金は発生しません。\n\n ■ デート日の確認はこちら \n https://web.bachelorapp.net/participation \n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "complete_1st_registation_female",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "female complete first registration",
        "content" => "バチェラーデートにご登録ありがとうございます！  \n 合格者には3日以内にEメールにて通知させていただきます！? \n \n ■ デート日の確認はこちら \n  https://web.bachelorapp.net/participation \n 当日の予定を空け、楽しみにお待ちください。\n\n  ■ デート～本合格の流れ \n https://wi.bachelorapp.net/new-flow-female \n \n ===  \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n \n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "approval_no_2nd_regisatration_male",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "male approval 2nd registration",
        "content" => "審査に合格しました！【24時間以内】にデートを確定して下さい。\n 無料でデートにご参加頂けます！ \n\n 【確定はこちら】\n :match_info_url_per_age \n\n デート日：\n:participated_date \n\n ・締切を過ぎるとデートがキャンセルされます。\n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => "match_info_url_per_age,participated_date"
    ],

    [
        "key" => "approval_no_2nd_regisatration_female",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "female approval 2nd registration",
        "content" => "【審査に仮合格しました！】24時間以内にデートを確定して下さい。\n \n 【確定はこちら】\n :match_info_url_per_age \n\n デート日 :\n :participated_date \n\n ・締切を過ぎるとデートがキャンセルされます。\n ・キャンセル後は、仮合格が取消となる場合があります。\n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => "match_info_url_per_age,participated_date"
    ],

    [
        "key" => "approval_no_2nd_regisatration_male",
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "male approval 2nd registration",
        "content" => "審査に合格しました！【18時間以内】\nにデートを確定して下さい。\n無料でデートにご参加頂けます！",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "approval_no_2nd_regisatration_female",
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "female approval 2nd registration",
        "content" => "審査に合格しました！【18時間以内】\nにデートを確定して下さい。",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "tempcancel_participated_no_2nd_registration_male",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "male temp cancel participated 2nd registration",
        "content" => "お相手が決まりました！【24時間以内】にデートを確定して下さい。\n 無料でデートにご参加頂けます！\n\n 【確定はこちら】\n :match_info_url_per_age \n\n ■ デート日の確認はこちら \n https://web.bachelorapp.net/participation \n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => "match_info_url_per_age"
    ],

    [
        "key" => "tempcancel_participated_no_2nd_registration_male",
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "male temp cancel participated 2nd registration",
        "content" => "お相手が決定しました！【18時間以内】\nにデートを確定して下さい。\n無料でデートにご参加頂けます！",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ""
    ],

    [
        "key" => "1st_reminder_for_2nd_registration_male",
        "eligible_user_key" => "first_reminder_for_2nd_registration_users",
        "type" => "email",
        "label" => "",
        "title" => "male 1st reminder for 2nd registration",
        "content" => "【:deadline_day_of_week 24時までにデートを確定ください】\n 確定されないと、自動的にデート無料体験がキャンセルとなります。 \n\n 【確定はこちら】\n https://bul.to/match-info-d \n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => "deadline_day_of_week"
    ],

    [
        "key" => "1st_reminder_for_2nd_registration_male",
        "eligible_user_key" => "first_reminder_for_2nd_registration_users",
        "type" => "sms",
        "label" => "",
        "title" => "male 1st reminder for 2nd registration",
        "content" => "【デート確定は:deadline_day_of_weekまで】\n  今回は保育士/モデル/ハイスペ女性が多数参加！1,500名以上！ \n :match_info_url_per_age",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "deadline_day_of_week,match_info_url_per_age"
    ],

    [
        "key" => "1st_reminder_for_2nd_registration_female",
        "eligible_user_key" => "first_reminder_for_2nd_registration_users",
        "type" => "email",
        "label" => "",
        "title" => "female 1st reminder for 2nd registration",
        "content" => "【:deadline_day_of_week 24時までにデートを確定ください】\n 確定されないと、自動的にデートがキャンセルとなり、仮合格取消となる場合があります。 \n\n 【確定はこちら】\n https://bul.to/match-info-f \n\n この機会にぜひハイスペック男性とのデートをお楽しみください? \n \n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => "deadline_day_of_week"
    ],

    [
        "key" => "1st_reminder_for_2nd_registration_female",
        "eligible_user_key" => "first_reminder_for_2nd_registration_users",
        "type" => "sms",
        "label" => "",
        "title" => "female 1st reminder for 2nd registration",
        "content" => "【デート確定は:deadline_day_of_weekまで】\n 今回は保育士/モデル/ハイスペ女性が多数参加！1,500名以上！\n :match_info_url_per_age",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "deadline_day_of_week,match_info_url_per_age"
    ],

    [
        "key" => "2nd_reminder_for_2nd_registration_male",
        "eligible_user_key" => "second_reminder_for_2nd_registration_users",
        "type" => "email",
        "label" => "",
        "title" => "male 2nd reminder for 2nd registration",
        "content" => "【:deadline_day_of_week 24時までにデートを確定ください】\n 確定されないと、自動的にデート無料体験がキャンセルとなります。 \n\n 【確定はこちら】\n https://bul.to/match-info-d \n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => "deadline_day_of_week"
    ],

    [
        "key" => "2nd_reminder_for_2nd_registration_male",
        "eligible_user_key" => "second_reminder_for_2nd_registration_users",
        "type" => "sms",
        "label" => "",
        "title" => "male 2nd reminder for 2nd registration",
        "content" => "【デート確定は:deadline_day_of_weekまで】\n 確定しないと無料体験は自動キャンセルとなります。\n :match_info_url_per_age",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "deadline_day_of_week,match_info_url_per_age"
    ],

    [
        "key" => "2nd_reminder_for_2nd_registration_female",
        "eligible_user_key" => "second_reminder_for_2nd_registration_users",
        "type" => "email",
        "label" => "",
        "title" => "female 2nd reminder for 2nd registration",
        "content" => "【:deadline_day_of_week 24時までにデートを確定ください】\n 確定されないと、自動的にデート無料体験がキャンセルとなります。\n\n 【確定はこちら】\n https://bul.to/match-info-d \n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => "deadline_day_of_week"
    ],

    [
        "key" => "2nd_reminder_for_2nd_registration_female",
        "eligible_user_key" => "second_reminder_for_2nd_registration_users",
        "type" => "sms",
        "label" => "",
        "title" => "female 2nd reminder for 2nd registration",
        "content" => "【デート確定は:deadline_day_of_weekまで】\n 確定しないと自動キャンセルとなります。\n :match_info_url_per_age",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "deadline_day_of_week,match_info_url_per_age"
    ],

    [
        "key" => "final_reminder_for_2nd_registration_male",
        "eligible_user_key" => "final_reminder_for_2nd_registration_users",
        "type" => "email",
        "label" => "",
        "title" => "male final reminder for 2nd registration",
        "content" => "【デートは確定されていません】\n 締め切りまであと12時間！\n\n 確定されないと、自動的にデート無料体験がキャンセルとなります。\n 【確定はこちら】\n https://bul.to/match-info-d \n\n バチェラーは厳しい審査を通過したハイスペック女子だけ。\n この機会に無料でハイスペック女子とデートしましょう！ \n\n ===== \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 28800,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "final_reminder_for_2nd_registration_male",
        "eligible_user_key" => "final_reminder_for_2nd_registration_users",
        "type" => "sms",
        "label" => "",
        "title" => "male final reminder for 2nd registration",
        "content" => "あと4時間以内にデートを確定しないと、無料体験は自動キャンセルとなります。\n :match_info_url_per_age",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "match_info_url_per_age"
    ],

    [
        "key" => "final_reminder_for_2nd_registration_female",
        "eligible_user_key" => "final_reminder_for_2nd_registration_users",
        "type" => "email",
        "label" => "",
        "title" => "female final reminder for 2nd registration",
        "content" => "【デートは確定されていません】\n 締め切りまであと12時間！\n\n 確定されないと、自動的にデート無料体験がキャンセルとなります。\n 【確定はこちら】 \n https://bul.to/match-info-d \n\n バチェラーは厳しい審査を通過したハイスペック男性だけ。\n この機会に無料でハイスペック男性とデートしましょう！\n\n ===== \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 28800,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "final_reminder_for_2nd_registration_female",
        "eligible_user_key" => "final_reminder_for_2nd_registration_users",
        "type" => "sms",
        "label" => "",
        "title" => "female final reminder for 2nd registration",
        "content" => "あと4時間以内にデートを確定しないと、自動キャンセルとなります。\n :match_info_url_per_age",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "match_info_url_per_age"
    ],

    [
        "key" => "2nd_registration_complete_male",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "male 2nd registration complete",
        "content" => "デートが確定されました！ 当日の予定を空けてお待ちください。\n\n  ■ デート日の確認はこちら \n https://bul.to/matchprofile \n\n ＊以降のキャンセルは、キャンセル料がかかりますのでお気を付けください。\n キャンセルポリシー　 \n https://bul.to/support-cancellation-m \n\n ■体験プラン \n 【:plan_nameプラン】(月額:plan_pricing円 / 1デートあたり:p_pricing_per_date円) \n \n 【無料期間】\n :trial_endまで \n\n その他お得なプランはコチラ \n https://wi.bachelorapp.net/plan \n\n * 無料期間を過ぎますと正会員へ自動更新となります。\n * 更新日に引落、以降1ヵ月毎の自動更新となります。\n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m \n\n ＝＝＝ \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => "trial_end,plan_name,plan_pricing,p_pricing_per_date"
    ],

    [
        "key" => "2nd_registration_complete_female",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "female 2nd registration complete",
        "content" => "デートが確定されました！ 当日の予定を空けてお待ちください。\n\n  ■ デート日の確認はこちら \n https://bul.to/matchprofile \n\n デート確定後のキャンセルは、お相手にも迷惑がかかるためキャンセル料がかかります、お気を付けください。\n\n  ■ キャンセルポリシー　 \n https://bul.to/support-cancellation-m \n\n  素敵な出会いがありますように? \n\n ＝＝＝\n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "2nd_registration_complete_male",
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "male 2nd registration complete",
        "content" => "デートが確定されました！\n詳細はEメールを確認ください。\n以降のキャンセルは料金がかかるのでお気をつけ下さい。",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "2nd_registration_complete_female",
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "female 2nd registration complete",
        "content" => "デートが確定されました！\n詳細はEメールを確認ください。\n以降のキャンセルは料金がかかるのでお気をつけ下さい。",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "auto_cancel_no_2nd_registration_male",
        "eligible_user_key" => "auto_cancel_participation_users",
        "type" => "email",
        "label" => "",
        "title" => "male auto cancel 2nd registration",
        "content" => "【デートはキャンセルされました】\n\n デート未確定のため自動的にデートはキャンセルされました。\n\n 無料期間内にデートに参加いただけなかったため、もう一度無料体験が可能です \n 早速予約しましょう \n \n 参加はこちら \n \n\n 予約時に新しい無料期間が始まります \n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n \n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 86400,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "auto_cancel_no_2nd_registration_male",
        "eligible_user_key" => "auto_cancel_participation_users",
        "type" => "sms",
        "label" => "",
        "title" => "male auto cancel 2nd registration",
        "content" => "【無料期間を延長しました】 期間中一度も参加頂けなかったため、無料期間が延長されました 詳細はEメールをご確認ください。",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "auto_cancel_no_2nd_registration_female",
        "eligible_user_key" => "auto_cancel_participation_users",
        "type" => "email",
        "label" => "",
        "title" => "female auto cancel 2nd registration",
        "content" => "【デートはキャンセルされました】\n\n デート未確定のため、下記の方とのデートは自動キャンセルとなりました。\n 【27歳・商社・183cm・早稲田大学】 \n\n 本合格にはデート参加が必須です。 \n 参加はこちら \n\n  ＝＝＝＝ \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "participation_reminder_tempcancel_male",
        "eligible_user_key" => "temp_cancel_trial_no_participant_users",
        "type" => "email",
        "label" => "",
        "title" => "male participation reminder temp cancel",
        "content" => "今週のデートには参加されますか?今なら1回無料！\n\n 【参加】\n https://web.bachelorapp.net/participation-steps \n\n 無料期間は予約したら始まります！\n ====== \n 今週の参加者? \n ・23歳/保育士/普通/156cm \n ・25歳/ブライダル/スリム/159cm \n ・26歳/美容師/やや細め/155cm \n ・29歳/秘書/スリム/165cm \n ・31歳/客室乗務員/やや細め/163cm \n など、毎週1,500名以上！\n\n ====== \n コロナでも安心！予防対策実施中！\n\n カフェデート/ビデオデートを選べるようになりました✨\n\n 詳細はこちら \n https://bachelorapp.zendesk.com/hc/ja/sections/900000649206 \n ===== \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 32400,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "participation_reminder_tempcancel_male",
        "eligible_user_key" => "temp_cancel_trial_no_participant_users",
        "type" => "sms",
        "label" => "",
        "title" => "male participation reminder temp cancel",
        "content" => "今週のデートには参加しますか？ bul.to/steps 今なら1回無料で参加できます！",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "1st_participation_complete_female",
        "eligible_user_key" => "first_dating_completed_users",
        "type" => "email",
        "label" => "",
        "title" => "female 1st participation complete",
        "content" => "【バチェラーデート】バチェラーデートに本合格しました！ \n\n おめでとうございます? \n より希望に沿った方とマッチされやすくなります。\n\n === \n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "unapproved_male",
        "eligible_user_key" => 'unapproved_users',
        "type" => "email",
        "label" => "",
        "title" => "unapprove male",
        "content" => "【ご予約頂いたデートはキャンセルとなりました】\n\n バチェラーデートにご応募頂きありがとうございます。大変残念ながら、この度は審査に通過しませんでした。合格基準を満たしていないか、男性が順番待ちとなっている可能性がございます。\n\n 現在大変多くの方にご応募いただいており、通過された方には順次お知らせいたします。\n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "unapproved_female",
        "eligible_user_key" => 'unapproved_users',
        "type" => "email",
        "label" => "",
        "title" => "unapproved female",
        "content" => "【ご予約頂いたデートはキャンセルとなりました】\n\n バチェラーデートにご応募頂きありがとうございます。大変残念ながら、この度は審査に通過しませんでした。合格基準を満たしていないか、女性が順番待ちとなっている可能性がございます。\n\n 現在大変多くの方にご応募いただいており、通過された方には順次お知らせいたします。\n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n \n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    /********** END REGISTRATION & APPROVAL ***********/

    [
        "key" => "notification_completed_dating_female",
        "eligible_user_key" => "female_completed_dating_today_no_feedback",
        "type" => "email",
        "label" => "",
        "title" => "Notification completed dating at 9pm wednesday for female",
        "content" => "デートは楽しめましたか？?今回のデートの改善シートをご記入ください。\n\n *お相手には表示されません。\n\n シートを記入するとAIが学習し、マッチ度がアップしていきます！? \n\n ▼記入はこちら▼ \n :feedback_url \n\n === \n ===== \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "feedback_url"
    ],
    [
        "key" => "notification_completed_dating_male",
        "eligible_user_key" => "male_completed_dating_today_no_feedback",
        "type" => "email",
        "label" => "",
        "title" => "Notification completed dating at 9pm wednesday for male",
        "content" => "デートは楽しめましたか？?今回のデートの改善シートをご記入ください。\n\n *お相手には表示されません。\n\n シートを記入するとAIが学習し、マッチ度がアップしていきます！? \n\n ▼記入はこちら▼ \n :feedback_url \n\n === \n ===== \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "feedback_url"
    ],

    [
        "key" => "notification_fill_wed_sat_sun_feedback_9pm_male",
        "eligible_user_key" => "user_no_fill_feedback_last_dating",
        "type" => "email",
        "label" => "",
        "title" => "Male notification fill feedback for last week",
        "content" => "明日24時までにデートの評価をするとAI学習が進みます\n\n【AI学習シート】の入力はこちら： :feedback_url\n*水曜夜までに記入しないと次回のマッチングに学習が反映されません\n\nAIが学習する程マッチングの精度が上がり、理想のお相手とデートに行けます😆\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 129600,
        "status" => 1,
        "variables" => "feedback_url"
    ],
    [
        "key" => "notification_fill_wed_sat_sun_feedback_9pm_male",
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Male notification fill feedback for last week",
        "content" => "【3時間以内】に【AI学習シート】を記入してください： :feedback_url \n *マッチングに反映されません ",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "feedback_url"
    ],

    [
        "key" => "notification_fill_wed_sat_sun_feedback_9pm_female",
        "eligible_user_key" => "user_no_fill_feedback_last_dating",
        "type" => "email",
        "label" => "",
        "title" => "Female notification fill feedback for last week",
        "content" => "本日24時までにデートの評価をするとA.I.学習が進みます \n 【A.I.学習シート】の入力はこちら： :feedback_url \n *日曜夜までに記入しないと次回のマッチングに学習が反映されません \n A.I.が学習する程マッチングの精度が上がり、理想のお相手とデートに行けます😆 \n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 https://bul.to/support-mail-setting \n  ■ よくある質問・ヘルプ https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "feedback_url"
    ],

    [
        "key" => "notification_fill_wed_sat_sun_feedback_9pm_female",
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Female notification fill feedback for last week",
        "content" => "",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "feedback_url"
    ],

    [
        "key" => "notification_suggestion_for_invite_after_feedback_female",
        "eligible_user_key" => '',
        "type" => "email",
        "label" => "",
        "title" => "Female notification suggest for invite after feedback",
        "content" => "シートのご記入ありがとうございます \n\n 今なら友達招待で よりハイスペック男性と出会えるバチェラーチケットをプレゼント? \n\n 友人を招待する \n https://web.bachelorapp.net/invite-friends \n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "dating_report_updated_male_users",
        "eligible_user_key" => "display_dating_report_today",
        "type" => "email",
        "label" => "",
        "title" => "Dating report updated",
        "content" => "バチェラーレポートが更新されました✨ \n\nレポート確認はこちら: https://web.bachelorapp.net/evaluation\n\n■バチェラーレポートについて\n・過去のデート評価を元に、あなたの強み / 改善点がわかります\n・恋愛力を向上させ、より素敵なお相手と出会いましょう！\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\nhttps://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "dating_report_updated_female_users",
        "eligible_user_key" => "display_dating_report_today",
        "type" => "email",
        "label" => "",
        "title" => "Dating report updated",
        "content" => "バチェラーレポートが更新されました✨\n\nレポート確認はこちら: https://web.bachelorapp.net/evaluation\n\n■バチェラーレポートについて\n・過去のデート評価を元に、あなたの強み / 改善点がわかります\n・恋愛力を向上させ、より素敵なお相手と出会いましょう！\n\n=====\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "dating_report_no_feedback_for_male_users",
        "eligible_user_key" => "completed_dating_no_f_b_by_partner",
        "type" => "email",
        "label" => "",
        "title" => "Dating report is not updated",
        "content" => "お相手が期日までに評価シートを記入しなかったため、レポートに反映されませんでした。\n\nあと【 :required_review_number_for_next_renewal 回】評価を受けると、バチェラーレポートが更新されます！✨\n\n■バチェラーレポートとは\n\n・過去のデート評価を元に、あなたの強み / 改善点がわかります\n・恋愛力を向上させ、より素敵なお相手と出会いましょう！\n\n詳細： https://bul.to/support-about-bachelor-report\n\n次回デートのご参加をお待ちしております！\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'required_review_number_for_next_renewal'
    ],
    [
        "key" => "dating_report_no_feedback_for_female_users",
        "eligible_user_key" => "completed_dating_no_f_b_by_partner",
        "type" => "email",
        "label" => "",
        "title" => "Dating report is not updated",
        "content" => "お相手が期日までに評価シートを記入しなかったため、レポートに反映されませんでした。\n\nあと【 :required_review_number_for_next_renewal 回】評価を受けると、バチェラーレポートが更新されます！✨\n\n■バチェラーレポートとは\n・過去のデート評価を元に、あなたの強み / 改善点がわかります\n・恋愛力を向上させ、より素敵なお相手と出会いましょう！\n\n詳細： https://bul.to/support-about-bachelor-report\n\n次回デートのご参加をお待ちしております！\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'required_review_number_for_next_renewal'
    ],
    [
        "key" => "dating_report_no_updated_for_female_users",
        "eligible_user_key" => "completed_dating_has_f_b_by_partner_no_display_report",
        "type" => "email",
        "label" => "",
        "title" => "Dating report is not updated",
        "content" => "あと【 :required_review_number_for_next_renewal 回】評価を受けると、バチェラーレポートが更新されます！✨\n\nレポートを完成させるために、デートに参加しましょう！\nデート参加はこちら： https://web.bachelorapp.net/participation\n\n■バチェラーレポートについて\n・過去のデート評価を元に、あなたの強み / 改善点がわかります\n・恋愛力を向上させ、より素敵なお相手と出会いましょう！\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'required_review_number_for_next_renewal'
    ],
    [
        "key" => "dating_report_no_updated_for_male_users",
        "eligible_user_key" => "completed_dating_has_f_b_by_partner_no_display_report",
        "type" => "email",
        "label" => "",
        "title" => "Dating report is not updated",
        "content" => "あと【 :required_review_number_for_next_renewal 回】評価を受けると、バチェラーレポートが更新されます！✨\n\nレポートを完成させるために、デートに参加しましょう！\nデート参加はこちら： https://web.bachelorapp.net/participation\n\n■バチェラーレポートについて\n・過去のデート評価を元に、あなたの強み / 改善点がわかります\n・恋愛力を向上させ、より素敵なお相手と出会いましょう！\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'required_review_number_for_next_renewal'
    ],

    // Cancel deactivate notification
    [
        "key" => "cancellation_requested_for_male_user",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Cancellation requested form",
        "content" => "退会フォームをご記入いただきありがとうございます。\n\n本日付けで受付致しました。\n処理が完了致しましたら、こちらよりご連絡致します。\n\nデートを体験済の方は次回再開時より正規会員となります。\n\n※手続き完了には数日お時間を頂いております。\n※利用料等の未払いがある場合は処理が完了しません、お気をつけください。\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => "cancellation_requested_for_female_user",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Cancellation requested form",
        "content" => "退会フォームをご記入いただきありがとうございます。\n\n本日付けで受付致しました。\n処理が完了致しましたら、こちらよりご連絡致します。\n\n※手続き完了には数日お時間を頂いております。\n※利用料等の未払いがある場合は処理が完了しません、お気をつけください。\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],

    [
        "key" => "deactivation_requested_for_male_user",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Deactivation requested form",
        "content" => "休会フォームをご記入いただきありがとうございます。\n\n本日付けで受付致しました。\n処理が完了致しましたら、こちらよりご連絡致します。\n\nデートを体験済の方は次回再開時より正規会員となります。\n\n※手続き完了には数日お時間を頂いております。\n※利用料等の未払いがある場合は処理が完了しません、お気をつけください。\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => "deactivation_requested_for_female_user",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Deactivation requested form",
        "content" => "休会フォームをご記入いただきありがとうございます。\n\n本日付けで受付致しました。\n処理が完了致しましたら、こちらよりご連絡致します。\n\n※手続き完了には数日お時間を頂いております。\n※利用料等の未払いがある場合は処理が完了しません、お気をつけください。\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'one_more_trial_requested_for_male_user',
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Trial requested is sent",
        "content" => "もう一度無料期間を体験できます！\n\nデート予約をすると無料期間が開始します\n\nデート1回無料！\n参加はこちら\n web.bachelorapp.net/participation\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'one_more_trial_requested_for_male_user',
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Trial requested is sent",
        "content" => "【あと1回無料デートに参加できます】予約はこちら！",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'reapproved_for_male_user',
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Reapproved",
        "content" => "再開処理が完了しました！\n\n再審査に通過し再開処理が完了しました！本日よりデート参加が可能です\n\n予約はこちら\n\n【当月ご利用期間】\n:subscription_start_date ~ :subscription_end_date (*以降1ヵ月毎の自動更新)\n\n【プラン】\n:plan_name（月額:plan_pricing 円 / 1デートあたり:p_pricing_per_date円）\nその他お得なプランはコチラ\n https://wi.bachelorapp.net/plan\n*デートを体験済の方は再開時からご利用料金が発生します。\n\n素敵な出会いが見つかるよう、恋活をサポートさせていただきますね！?\n\nお相手やご自身の情報変更はこちらのヘルプページから可能です。\n https://bul.to/support-acount-setting-m\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 3600,
        "status" => 1,
        "variables" => 'subscription_start_date,subscription_end_date,plan_name,plan_pricing'
    ],
    [
        "key" => 'reapproved_for_male_user',
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Reapproved",
        "content" => "再開処理が完了しました！ 早速参加しましょうbit.ly/2IZ1Q1U 詳細はEメールをご確認ください。",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'reapproved_for_female_user',
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Reapproved",
        "content" => "【再開処理が完了しました！デートへご参加頂けます。】\nおめでとうございます！\n再審査に通過し、本日よりデートへご参加頂けます。\n\n素敵な出会いが見つかるよう、恋活をサポートさせていただきますね！\n\n予約はこちら\n web.bachelorapp.net/participation\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 3600,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'reapproved_for_female_user',
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Reapproved",
        "content" => "再開処理が完了しました！ 早速参加しましょうbit.ly/2IZ1Q1U 詳",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'reactivated_trial_for_male_user',
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Reactivated for trial male user",
        "content" => "再開のご連絡頂きありがとうございます！\n\n過去審査に合格済で現在「休会」中のため、再審査なしで今週末よりデートへご参加頂けます。\nまた、無料期間中一度もデートへ参加されたことがないため、1週間無料でご利用いただけます。\n\n【無料期間】  :trial_start 〜 :trial_end（無料期間を過ぎますと正会員へ自動更新となります。）\n\n【体験プラン】\n :plan_name（月額:plan_pricing円 / 1デートあたり:p_pricing_per_date円）\nその他お得なプランはコチラ\n https://wi.bachelorapp.net/plan\n\n素敵な出会いが見つかるよう、恋活をサポートさせていただきますね！?\n\nお相手やご自身の情報変更はこちらのヘルプページから可能です。\n https://bachelorapp.zendesk.com/hc/ja/sections/900000616466\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 3600,
        "status" => 1,
        "variables" => 'trial_start,trial_end,plan_name,plan_pricing'
    ],
    [
        "key" => 'reactivated_trial_for_male_user',
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Reactivated for trial male user",
        "content" => "再開処理が完了しました！ 早速参加しましょうbit.ly/2IZ1Q1U 詳細はEメールをご確認ください。",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'reactivated_for_male_user',
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Approved",
        "content" => "再開処理が完了しました！\n\n過去審査に合格済で現在「休会」中のため、再審査なしでデートへご参加頂けます。\n予約はこちら\n\n【当月ご利用期間】\n :subscription_start_date ~ :subscription_end_date (*以降1ヵ月毎の自動更新)\n\n【プラン】\n :plan_name（月額:plan_pricing円 / 1デートあたり:p_pricing_per_date円）\nその他お得なプランはコチラ\n https://wi.bachelorapp.net/plan\n*デートを体験済の方は再開時からご利用料金が発生します。\n\n素敵な出会いが見つかるよう、恋活をサポートさせていただきますね！?\n\nお相手やご自身の情報変更はこちらのヘルプページから可能です。\n https://bul.to/support-acount-setting-m\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'subscription_start_date,subscription_end_date,plan_name,plan_pricing'
    ],
    [
        "key" => 'reactivated_for_female_user',
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Approved",
        "content" => "【再開処理が完了しました！本日よりデートの予約が可能です】\n\n再開処理が完了しました！\n\n過去審査に合格済で現在「休会」中のため、再審査なしでデートへご参加頂けます。\n\n参加はこちら\n web.bachelorapp.net/participation\n\n素敵な出会いが見つかるよう、恋活をサポートさせていただきますね！\n\nお相手やご自身の情報変更はこちらのヘルプページから可能です。\n https://bul.to/support-acount-setting-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'reapproved_for_trial_male_user',
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Reapproved trial",
        "content" => "再開処理が完了しました！\n\n再審査に通過し再開処理が完了しました！\nまた、無料期間中一度もデートへ参加されたことがないため、1週間無料でご利用いただけます。\n\n予約をしたら、無料期間が開始します\n予約はこちら\n\n【体験プラン】\n :plan_name（月額:plan_pricing円 / 1デートあたり:p_pricing_per_date円）\nその他お得なプランはコチラ\n https://wi.bachelorapp.net/plan\n\n素敵な出会いが見つかるよう、恋活をサポートさせていただきますね！?\n\nお相手やご自身の情報変更はこちらのヘルプページから可能です。\n https://bachelorapp.zendesk.com/hc/ja/sections/900000616466\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 3600,
        "status" => 1,
        "variables" => 'plan_name,plan_pricing,p_pricing_per_date'
    ],
    [
        "key" => 'reapproved_for_trial_male_user',
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Reapproved trial",
        "content" => "再開処理が完了しました！ 早速参加しましょう\nbit.ly/2IZ1Q1U\n詳細はEメールをご確認ください。",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'uncollective_deactivated_for_male_user',
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "UnCollective Deactivated",
        "content" => "アカウントが停止しました\n\n料金が未払いのためアカウントが停止しました\n\nこちらからお支払いください\n\n期限\n\nお支払いが完了し次第アカウントが再開されます",
        "prefectures" => null,
        "follow_interval" => 86400,
        "status" => 1,
        "variables" => 'hosted_invoice_urls'
    ],
    [
        "key" => 'uncollective_deactivated_for_male_user',
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "UnCollective Deactivated",
        "content" => "未払いがあるためアカウントが停止しました。詳しくはEメールをご覧ください。",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'uncollective_deactivated_for_female_user',
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "UnCollective Deactivated",
        "content" => "アカウントが停止しました\n\n料金が未払いのためアカウントが停止しました\n\nこちらからお支払いください\n\n期限\n\nお支払いが完了し次第アカウントが再開されます",
        "prefectures" => null,
        "follow_interval" => 86400,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'uncollective_deactivated_for_female_user',
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "UnCollective Deactivated",
        "content" => "未払いがあるためアカウントが停止しました。詳しくはEメールをご覧ください。",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    // Change plan
    [
        "key" => 'upgrade_plan',
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Upgrade plan",
        "content" => ":new_planへの変更手続が完了しました！\n\n・本日より新プランが適用されます。\n・料金は次回更新より変更となります。\n・次回更新日：:next_renewal_day\n\n次回のデートから、:new_planでのデートをお楽しみください！?\n [participationのリンクを入れる]\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\nhttps://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'new_plan,next_renewal_day,'
    ],
    [
        "key" => 'downgrade_plan',
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Downgrade plan",
        "content" => ":new_planへの変更手続が完了しました！\n・次の更新日より、プランの変更が適用されます。\n・次回更新日：:next_renewal_day 今期間中は引き続き、:current_planでのデートをお楽しみください！😊\n\nデート参加はこちら\n===\n■ よくある質問・ヘルプ https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'new_plan,next_renewal_day,current_plan,'
    ],
    // Participate notification
    [
        "key" => 'participation_reminder_has_no_participation_for_male_users',
        "eligible_user_key" => "approved_users_completed_2nd_form_and_no_participation_this_week",
        "type" => "email",
        "label" => "",
        "title" => "Participation reminder",
        "content" => "今週のデートには参加されますか?\n\n【参加】https://web.bachelorapp.net/participation-steps\n\n*参加がない週は、日曜日にデートチケットが発行されます。\n\n======\n\nコロナでも安心！予防対策実施中！\n下記よりデート方法を選べます✨\n\nカフェデート/ビデオデート\n\n詳細はこちら\n https://bul.to/support-COVID-19-m\n\n======\n\n今週の参加者?\n\n・23歳/保育士/普通/156cm\n・25歳/ブライダル/スリム/159cm\n・26歳/美容師/やや細め/155cm\n・29歳/秘書/スリム/165cm\n・31歳/客室乗務員/やや細め/163cm\n\nなど、毎週1,500名以上！\n\n=====\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 32400,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'participation_reminder_has_no_participation_for_female_users',
        "eligible_user_key" => "approved_users_completed_2nd_form_and_no_participation_this_week",
        "type" => "email",
        "label" => "",
        "title" => "Participation reminder",
        "content" => "今週のデートには参加されますか?\n\n【参加】https://web.bachelorapp.net/participation-steps\n\n\n======\n\nコロナでも安心！予防対策実施中！\n下記よりデート方法を選べます✨\n\nカフェデート/ビデオデート\n\n詳細はこちら\n https://bul.to/support-COVID-19-m\n\n=====\n\n今週の参加者?\n\n・26歳/IT企業/600万/名古屋大学/182cm\n・28歳/商社/700万/北海道大学/178cm\n・30歳/経営者/1000万/早稲田大学/175cm\n・35歳/弁護士/2000万/大阪大学/185cm\n・29歳/外資コンサル/1500万/一橋大学/176cm\n\nなど、毎週1,500名以上！\n厳しい審査を通過したハイスペック男性だけ?\n\n=====\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 32400,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'participation_reminder_has_no_participation_for_male_users',
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Participation reminder",
        "content" => "今週のデートには参加しますか？ bul.to/steps 今週は保育士等ハイスペ女性が多数参加！1,500名以上！",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'participation_reminder_has_no_participation_for_female_users',
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Participation reminder",
        "content" => "今週のデートには参加しますか？ bul.to/steps 今週は経営者等ハイスペ男性多数参加！1,500名以上！",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    [
        "key" => 'participation_reminder_has_participation_for_male_users',
        "eligible_user_key" => "approved_users_completed_2nd_form_and_have_participation_this_week",
        "type" => "email",
        "label" => "",
        "title" => "Participation reminder",
        "content" => "今週デートこちらです。他の日も参加しますか？\n・:dating_date_this_week_list\n\n土曜デートは確定しています。予定を空けてお待ちください。\n\n:participation_text\n\n※たくさん参加するとAIの学習がUP！理想の人とすぐ会えるかも？\n\n======\n\n今週の参加者😆\n・29歳 /医師/やや細め/177cm\n・35歳 /商社 /スリム/164cm\n・34歳 /金融 /やや細め/174cm\n・27歳 /公務員/普通/162cm\n・30歳 /商社/スリム/161cm\nなど、毎週1,500名以上！\n\n=====\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n\n■ よくある質問・ヘルプ\nhttps://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 32400,
        "status" => 1,
        "variables" => 'dating_date_this_week_list,participation_text'
    ],
    [
        "key" => 'participation_reminder_has_participation_for_female_users',
        "eligible_user_key" => "approved_users_completed_2nd_form_and_have_participation_this_week",
        "type" => "email",
        "label" => "",
        "title" => "Participation reminder",
        "content" => "今週デートこちらです。他の日も参加しますか？\n・:dating_date_this_week_list\n\n土曜デートは確定しています。予定を空けてお待ちください。\n\n:participation_text\n\n※たくさん参加するとAIの学習がUP！理想の人とすぐ会えるかも？\n\n======\n\n今週not_@articipated_date_this_weekの参加者😆\n・29歳 /医師/やや細め/177cm\n・35歳 /商社 /スリム/164cm\n・34歳 /金融 /やや細め/174cm\n・27歳 /公務員/普通/162cm\n・30歳 /商社/スリム/161cm\nなど、毎週1,500名以上！\n\n=====\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 32400,
        "status" => 1,
        "variables" => 'dating_date_this_week_list,participation_text'
    ],
    [
        "key" => 'participation_reminder_has_participation_for_male_users',
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Participation reminder",
        "content" => "今週のデート予約確認はこちら！ \n bul.to/match-profile",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 0,
        "variables" => ''
    ],
    [
        "key" => 'participation_reminder_has_participation_for_female_users',
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Participation reminder",
        "content" => "今週のデート予約確認はこちら！\n bul.to/match-profile 他の日程も参加しますか？",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 0,
        "variables" => ''
    ],
    [
        "key" => '2nd_temp_cancel_2nd_registration_completed_for_male_user',
        "eligible_user_key" => "approved_or_trial_users_have_temp_cancelled_subscription_have_new_participation_completed_2nd_form",
        "type" => "email",
        "label" => "",
        "title" => "",
        "content" => "無料期間と体験プランのお知らせ\n\nデートを確定頂きありがとうございます。\nあなたの無料期間は本日から、:trial_end迄です。\n\n【体験プラン】\n:plan_name（月額:plan_pricing円 / 1デートあたり:p_pricing_per_date円）\n\nその他お得なプランはコチラ\n https://wi.bachelorapp.net/plan\n\n* 無料期間を過ぎますと正会員へ自動更新となります。\n* 更新日に引落、以降1ヵ月毎の自動更新となります。\n\n＝＝＝\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => 'trial_end,plan_name,plan_pricing,p_pricing_per_date'
    ],
    [
        "key" => '2nd_temp_cancel_2nd_registration_completed_for_male_user',
        "eligible_user_key" => "approved_or_trial_users_have_temp_cancelled_subscription_have_new_participation_completed_2nd_form",
        "type" => "sms",
        "label" => "",
        "title" => "",
        "content" => "【バチェラーデート合格】 おめでとうございます😊 無料期間 :trialEndまで *以降自動更新 詳細Eメールをお送りしています",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'trialEnd'
    ],
    [
        "key" => 'weekly_dating_coupon_issued_for_male_user',
        "eligible_user_key" => "approved_paid_users_participated_this_week",
        "type" => "email",
        "label" => "",
        "title" => "",
        "content" => "【デートチケットを発行しました】\n\n今週はデート参加がなかったため、デートチケットを発行しました\n\nデートチケットを利用すると1日追加でデートに参加いただけます\nデート予約はこちらから！\n https://web.bachelorapp.net/coupon\n\n*有効期限は【２ヶ月】です。\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => ''
    ],
    // Matching Notification
    [
        "key" => "matching_reminder_for_male_users",
        "eligible_user_key" => "users_matched_main_matching",
        "type" => "email",
        "label" => "",
        "title" => "Matching reminder",
        "content" => "本日15時にお相手を送ります\nお楽しみに！\n\nお相手に迷惑がかかるため、やむをえず欠席する場合は早めにキャンセルをしましょう。\n- 当日のキャンセル：3,000円\n- 無断欠席：6,000円\n\n\nビデオデートも選べます。\nご希望の場合、お相手には早めに当日チャットから連絡しましょう\n\n詳細はこちら\nhttps://bul.to/support-COVID-19-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "matching_reminder_for_female_users",
        "eligible_user_key" => "users_matched_main_matching",
        "type" => "email",
        "label" => "",
        "title" => "Matching reminder",
        "content" => "本日15時にお相手を送ります\nお楽しみに！\n\nお相手に迷惑がかかるため、やむをえず欠席する場合は早めにキャンセルをしましょう。\n- 当日のキャンセル：3,000円\n- 無断欠席：6,000円\n\n\nビデオデートも選べます。\nご希望の場合、お相手には早めに当日チャットから連絡しましょう\n\n詳細はこちら\nhttps://bul.to/support-COVID-19-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "matching_chat_open_for_male_users",
        "eligible_user_key" => "users_open_chat",
        "type" => "email",
        "label" => "",
        "title" => "Chat open",
        "content" => "明日のデート相手と時間が確定しました！\nこちらより、ご確認ください。\n https://bachelorapp.zendesk.com/hc/ja/articles/900005015763\n\n===\n緊急事態宣言が出たけど、デートはあるの？\n https://bachelorapp.zendesk.com/hc/ja/articles/900005166723\n===\n\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "matching_chat_open_for_male_users",
        "eligible_user_key" => "users_open_chat",
        "type" => "sms",
        "label" => "",
        "title" => "Chat open",
        "content" => "明日のデート相手と時間が確定しました！? \n こちらより、ご確認ください。\n https://bachelorapp.zendesk.com/hc/ja/articles/900005015763 \n \n === \n 緊急事態宣言が出たけど、デートはあるの？\n https://bachelorapp.zendesk.com/hc/ja/articles/900005166723 \n \n ===\n \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting\n \n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m", "prefectures" => null, "follow_interval" => 0, "status" => 1, "variables" => null
    ],
    [
        "key" => "matching_chat_open_for_female_users",
        "eligible_user_key" => "users_open_chat",
        "type" => "email",
        "label" => "",
        "title" => "Chat open",
        "content" => "明日のデート相手と時間が確定しました！\nこちらより、ご確認ください。\n https://bachelorapp.zendesk.com/hc/ja/articles/900005015763\n\n===\n緊急事態宣言が出たけど、デートはあるの？\n https://bachelorapp.zendesk.com/hc/ja/articles/900005166723\n===\n\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 21600,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "matching_chat_open_for_female_users",
        "eligible_user_key" => "users_open_chat",
        "type" => "sms",
        "label" => "",
        "title" => "Chat open",
        "content" => "明日のデート相手と時間が確定しました！? \n こちらより、ご確認ください。\n https://bachelorapp.zendesk.com/hc/ja/articles/900005015763 \n \n === \n 緊急事態宣言が出たけど、デートはあるの？\n https://bachelorapp.zendesk.com/hc/ja/articles/900005166723 \n \n ===\n \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting\n \n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m", "prefectures" => null, "follow_interval" => 0, "status" => 1, "variables" => null
    ],

    [
        "key" => "matching_chat_open_for_fake_female_users",
        "eligible_user_key" => "fake_users_open_chat",
        "type" => "email",
        "label" => "",
        "title" => "Chat open",
        "content" => "明日のデート相手と時間が確定しました！\nこちらより、ご確認ください。\n https://bachelorapp.zendesk.com/hc/ja/articles/900005015763\n\n===\n緊急事態宣言が出たけど、デートはあるの？\n https://bachelorapp.zendesk.com/hc/ja/articles/900005166723\n===\n\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "matching_chat_open_for_fake_male_users",
        "eligible_user_key" => "fake_users_open_chat",
        "type" => "email",
        "label" => "",
        "title" => "Chat open",
        "content" => "明日のデート相手と時間が確定しました！\nこちらより、ご確認ください。\n https://bachelorapp.zendesk.com/hc/ja/articles/900005015763\n\n===\n緊急事態宣言が出たけど、デートはあるの？\n https://bachelorapp.zendesk.com/hc/ja/articles/900005166723\n===\n\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "not_matched_for_female_users_in_main_matching",
        "eligible_user_key" => "users_not_matched_in_main_matching",
        "type" => "email",
        "label" => "",
        "title" => "No matched",
        "content" => "満員御礼！\n現在大変多くの女性に参加を頂いており、明日は男性が全員ほかにお相手が見つかってしまいました。\n\n明日のデートは【キャンセル待ち】となりました?\n当日ご希望に沿った男性が現れた際に、Eメールよりご案内させて頂きます。\n\n※満員御礼とキャンセル待ちについて\n https://bachelorapp.zendesk.com/hc/ja/sections/900000663226\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "matched_rematching_for_female",
        "eligible_user_key" => "users_matched_rematching",
        "type" => "email",
        "label" => "",
        "title" => "Matched rematching",
        "content" => "新しいお相手が見つかりました！本日のデート場所とお相手の詳細です！?\n\nこちらから詳細、チャットで挨拶をしましょう✨\n https://bul.to/matchprofile\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 3600,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "matched_rematching_for_female",
        "eligible_user_key" => "users_matched_rematching",
        "type" => "sms",
        "label" => "",
        "title" => "Matched rematching",
        "content" => "お相手が見つかりました こちらにログインし、ご確認とチャットをご利用下さい！ bit.ly/2B0IEPS",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "matched_rematching_for_male",
        "eligible_user_key" => "users_matched_rematching",
        "type" => "email",
        "label" => "",
        "title" => "Matched rematching",
        "content" => "新しいお相手が見つかりました！本日のデート場所とお相手の詳細です！?\n\nこちらから詳細、チャットで挨拶をしましょう✨\n https://bul.to/matchprofile\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 3600,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "matched_rematching_for_male",
        "eligible_user_key" => "users_matched_rematching",
        "type" => "sms",
        "label" => "",
        "title" => "Matched rematching",
        "content" => "お相手が見つかりました こちらにログインし、ご確認とチャットをご利用下さい！ bit.ly/2B0IEPS",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "not_matched_rematching_for_male",
        "eligible_user_key" => "male_users_not_matched_rematching",
        "type" => "email",
        "label" => "",
        "title" => "Not matched rematching",
        "content" => "【デートチケットを発行しました】\n\n誠に残念ですが、本日会える他のお相手が見つかりませんでした。\n\nデートに参加頂けなかったため、デートチケットを発行致しました\n*有効期限は【２ヶ月】です。\n\nデート予約はこちら\n:coupon_return_text\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\nhttps://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\nhttps://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'coupon_return_text'
    ],
    [
        "key" => "not_matched_rematching_for_female",
        "eligible_user_key" => "female_users_not_matched_rematching",
        "type" => "email",
        "label" => "",
        "title" => "Not matched rematching",
        "content" => "【バチェラーチケットを発行しました】\n\n誠に残念ですが、本日会える他のお相手が見つかりませんでした。\n\nデートに参加頂けなかったため、バチェラーチケットを発行致しました?\n\n*有効期限は【２ヶ月】です。\nデート予約はこちら\n\n:coupon_return_text\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\nhttps://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\nhttps://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'coupon_return_text'
    ],
    [
        "key" => "not_matched_rematching_for_trial_male_users",
        "eligible_user_key" => "trial_male_users_not_matched_rematching",
        "type" => "email",
        "label" => "",
        "title" => "Not matched rematching",
        "content" => "【もう1回無料でデートに参加できます】\n\n誠に残念ですが、本日会える他のお相手が見つかりませんでした。\n\nデートに参加頂けなかったため、もう一度無料デート体験ができます\n\n\nデート予約はこちら\n予約時に無料期間が開始します。\n\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 10800,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "not_matched_rematching_for_trial_male_users",
        "eligible_user_key" => "trial_male_users_not_matched_rematching",
        "type" => "sms",
        "label" => "",
        "title" => "Not matched rematching",
        "content" => "【あと1回無料デートに参加できます】 お相手のご都合によりキャンセルとなったため、もう一度無料体験ができます。本日お送りしたEメールをご確認ください！",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "rematching_reminder_for_female_users",
        "eligible_user_key" => "users_can_participate_rematching_today",
        "type" => "email",
        "label" => "",
        "title" => "Rematching reminder",
        "content" => "本日のデートに空きがでました！\n\nご希望の方は【12時】までに下記より申請してください。\n https://web.bachelorapp.net/12pm-rematching-application?id=:dating_day_id\n\n先着順となります、ご希望の方はぜひお早めに?\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 10800,
        "status" => 1,
        "variables" => 'dating_day_id'
    ],
    [
        "key" => "rematching_reminder_for_female_users",
        "eligible_user_key" => "users_can_participate_rematching_today",
        "type" => "sms",
        "label" => "",
        "title" => "Rematching reminder",
        "content" => "本日のデートに空きがでました！ 参加は【12時まで】 https://web.bachelorapp.net/12pm-rematching-application?id=:dating_day_id 先着順となります！ぜひお早めに！",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'dating_day_id'
    ],

    [
        "key" => "matching_chat_open_fake_for_female_users",
        "eligible_user_key" => "users_not_matched_in_main_matching",
        "type" => "email",
        "label" => "",
        "title" => "Rematching reminder",
        "content" => "明日のデート相手と時間が確定しました！こちらより、ご確認ください。\n https://bachelorapp.zendesk.com/hc/ja/articles/900005015763 \n 緊急事態宣言が出たけど、デートはあるの？\n https://bachelorapp.zendesk.com/hc/ja/articles/900005166723 \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n ■ よくある質問・ヘルプ",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "dating_reminder_for_male_users",
        "eligible_user_key" => "users_have_incompleted_date_on_dating_day",
        "type" => "email",
        "label" => "",
        "title" => "Dating reminder",
        "content" => "いよいよデートですね!\n\n日時：:dating_from\n場所：:station_name\n\n連絡なしの不参加はキャンセル料（自動引落）が上がります。やむを得ずキャンセルする場合は【1時間前】までに連絡しましょう。\n\nまた、バチェラーデートでは毎回デートで高評価を得るほど、次回よりよいお相手とマッチされやすくなります。気品あるバチェラー会員としての自覚をもって、ぜひデートを楽しんできてくださいね?\n\n※ 遅刻、強引な勧誘、相手に不快感を与えるなど、バチェラー会員としてふさわしくない行動が続いた場合、アカウントを停止させて頂くことがございます。\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\nhttps://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\nhttps://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "dating_from,station_name"
    ],
    [
        "key" => "dating_reminder_for_female_users",
        "eligible_user_key" => "users_have_incompleted_date_on_dating_day",
        "type" => "email",
        "label" => "",
        "title" => "Dating reminder",
        "content" => "いよいよデートですね!\n\n日時：:dating_from\n場所：:station_name\n\n連絡なしの不参加はキャンセル料（自動引落）が上がります。やむを得ずキャンセルする場合は【1時間前】までに連絡しましょう。\n\nまた、バチェラーデートでは毎回デートで高評価を得るほど、次回よりよいお相手とマッチされやすくなります。気品あるバチェラー会員としての自覚をもって、ぜひデートを楽しんできてくださいね?\n\n※ 遅刻、強引な勧誘、相手に不快感を与えるなど、バチェラー会員としてふさわしくない行動が続いた場合、アカウントを停止させて頂くことがございます。\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\nhttps://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\nhttps://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "dating_from,station_name"
    ],

    [
        "key" => "rematching_requested_not_matched_for_female_users",
        "eligible_user_key" => "users_requested_not_matched_rematching",
        "type" => "email",
        "label" => "",
        "title" => "Requested not matched",
        "content" => "デート参加のお申込みありがとうございます。\n\n大変残念ですが、本日の先着枠はすべて埋まってしまいました\n\n次回のデートはこちらから予約できます\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "notification_referral_recommendation_male",
        "eligible_user_key" => '',
        "type" => "email",
        "label" => "",
        "title" => "Male Notification for referral recommendation",
        "content" => "シートのご記入ありがとうございます? \n\n 今なら友達招待で 無料でデートに行ける振替チケット(¥5,000相当)をプレゼント? \n\n   友人を招待する https://web.bachelorapp.net/invite-friends \n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "cancel_rematching_one_more_trial_for_male_user",
        "eligible_user_key" => "trial_male_user_cancel_rematching",
        "type" => "email",
        "label" => "",
        "title" => "Cancel rematching",
        "content" => "【今週のデートはキャンセルとなりました】\n\n\n本日のデートは、お相手のご都合によりキャンセルとなったため、もう一度無料でデート参加ができます\n\n予約すると無料期間が開始します。\n\n予約はこちら\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "change_preference_recommendation_to_female",
        "eligible_user_key" => '',
        "type" => "email",
        "label" => "",
        "title" => "Female notification for change preference recommendation",
        "content" => "【お相手にご満足頂けませんでしたか？】 \n\n ■より良いお相手とマッチングするには？\n 1. ご希望の条件を見直してみましょう！\n 　例）希望年齢を5つ上げると、マッチング対象者が60%広がる場合があります。\n 変更はこちら：https://web.bachelorapp.net/profile \n\n 2. デートで高評価を得るほど、より良い相手とマッチングしやすくなります！ \n バチェラーレートを確認：https://web.bachelorapp.net/evaluation \n \n  ＝＝＝＝ \n \n ■不快/規約違反のユーザーがいた場合 \n バチェラーデートでは悪質なユーザーには警告や強制退会などの措置を行います。\n こちらより報告をお願いします。\n https://forms.gle/2Db14Z4XRPJw2yHeA \n\n *問題ユーザーと認定された場合、チケットを発行致します。\n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-f",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "cancel_rematching_one_more_trial_for_male_user",
        "eligible_user_key" => "trial_male_user_cancel_rematching",
        "type" => "sms",
        "label" => "",
        "title" => "Cancel rematching",
        "content" => "【あと1回無料デートに参加できます】デートをお楽しみいただけなかったため、もう一度無料体験ができます。本日お送りしたEメールをご確認ください！",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "cancel_one_more_trial_for_male_user",
        "eligible_user_key" => "trial_male_user_cancel",
        "type" => "email",
        "label" => "",
        "title" => "Cancel rematching",
        "content" => "【今週のデートはキャンセルとなりました】\n\n期間中一度も参加頂けなかったため、もう一度無料でデート参加ができます\n\n予約すると無料期間が開始します。\n\n予約はこちら\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "cancel_one_more_trial_for_male_user",
        "eligible_user_key" => "trial_male_user_cancel",
        "type" => "sms",
        "label" => "",
        "title" => "Cancel rematching",
        "content" => "【あと1回無料デートに参加できます】\nデートをお楽しみいただけなかったため、もう一度無料体験ができます。本日お送りしたEメールをご確認ください！",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "notification_change_preference_recommendation_male",
        "eligible_user_key" => '',
        "type" => "email",
        "label" => "",
        "title" => "Male notifciation for change preference recommendation",
        "content" => "【お相手にご満足頂けませんでしたか？】\n\n マッチングはプラン・希望条件・バチェラーレートの3つを中心に行われています！\n ■より良いお相手とマッチングするには？ \n\n\n\n         プランをグレードアップ！ \n           https://www.wi.bachelorapp.net/plan \n \n        2. ご希望の条件を見直してみましょう！\n             例）希望年齢を5つ上げると、マッチング対象者が60%拡がります \n             https://web.bachelorapp.net/profile \n \n    　3.バチェラーレートをあげましょう！\n 　　   レートが高いとより良いお相手とマッチングされやすくなります✨\n           https://web.bachelorapp.net/evaluation \n\n  ＝＝＝＝ \n ■不快/規約違反のユーザーがいた場合 \n\n バチェラーデートでは悪質なユーザーには警告や強制退会などの措置を行います。\n こちらより報告をお願いします \n https://forms.gle/2Db14Z4XRPJw2yHeA \n\n  *問題ユーザーと認定された場合、チケットを発行致します。\n \n  === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "cancelled_after_rematching_time_trial_male_user",
        "eligible_user_key" => "trial_male_user_cancelled_after_rematching_time",
        "type" => "email",
        "label" => "",
        "title" => "Cancel rematching",
        "content" => "【今週のデートはキャンセルとなりました】\n\n期間中一度も参加頂けなかったため、もう一度無料でデート参加ができます\n\n予約すると無料期間が開始します。\n\n予約はこちら\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 10800,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "cancelled_after_rematching_time_trial_male_user",
        "eligible_user_key" => "trial_male_user_cancelled_after_rematching_time",
        "type" => "sms",
        "label" => "",
        "title" => "Cancel rematching",
        "content" => "【今週のデートはキャンセルとなりました】\n\n期間中一度も参加頂けなかったため、もう一度無料でデート参加ができます\n\n予約すると無料期間が開始します。\n\n予約はこちら\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],

    [
        "key" => "notification_long_term_plan_recommendation_male",
        "eligible_user_key" => '',
        "type" => "email",
        "label" => "【バチェラーデート特別ご招待】\n\nシートのご記入ありがとうございます!\n\n半額以下でお楽み頂けるプランもございます\n\nコスパ重視の方はこちら\n https://www.wi.bachelorapp.net/blank-73\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\nhttps://bul.to/support-bachelor-m",
        "title" => "Male notification long term plan recommendation",
        "content" => "",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "cancel_rematching_issue_coupon_for_male_user",
        "eligible_user_key" => "male_user_cancel_rematching_issue_coupon",
        "type" => "email",
        "label" => "",
        "title" => "Cancel rematching issue coupon",
        "content" => "【デートチケットを発行しました】\n\n 本日のデートは、お相手のご都合によりキャンセルとなったため、デートチケットを発行致しました。\n\n振替チケットのご利用はこちら\nhttps://web.bachelorapp.net/coupon\n\n*有効期限は【２ヶ月】です。\n\n:coupon_return_text\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\nhttps://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\nhttps://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "coupon_return_text"
    ],

    [
        "key" => "notification_premium_and_long_term_plan_recommendation_male",
        "eligible_user_key" => '',
        "type" => "email",
        "label" => "",
        "title" => "Male notification premium and long term plan recommendation",
        "content" => "【あなたにぴったりなプランを?】 \n シートのご記入ありがとうございます! \n\n 2種類のアップグレードを用意しております。 \n\n スペック重視の方はこちら \n CA, モデルなどハイスペ女性が倍増✨\n https://bit.ly/399WVFh \n\n コスパ重視の方はこちら \n プレミアムは最大30%お得に✨\n https://www.wi.bachelorapp.net/plan \n\n === \n ■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合 \n https://bul.to/support-mail-setting \n\n ■ よくある質問・ヘルプ \n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "cancel_rematching_issue_coupon_for_female_user",
        "eligible_user_key" => "female_user_cancel_rematching_issue_coupon",
        "type" => "email",
        "label" => "",
        "title" => "Cancel rematching issue coupon",
        "content" => "【デートチケットを発行しました】\n\n 本日のデートは、お相手のご都合によりキャンセルとなったため、デートチケットを発行致しました。\n\n振替チケットのご利用はこちら\nhttps://web.bachelorapp.net/coupon\n\n*有効期限は【２ヶ月】です。\n\n:coupon_return_text\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\nhttps://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\nhttps://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "coupon_return_text"
    ],
    [
        "key" => "cancelled_after_rematching_time_for_male_user",
        "eligible_user_key" => "male_user_cancelled_after_rematching_time",
        "type" => "email",
        "label" => "",
        "title" => "Cancelled after rematching",
        "content" => "【デートチケットを発行しました】\n\n本日のデートは、お相手のご都合によりキャンセルとなったため、デートチケットを発行致しました\n\n振替チケットのご利用はこちら\n https://web.bachelorapp.net/coupon\n\n*有効期限は【２ヶ月】です。\n\n:coupon_return_text\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\nhttps://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\nhttps://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "coupon_return_text"
    ],
    [
        "key" => "cancelled_after_rematching_time_for_female_user",
        "eligible_user_key" => "female_user_cancelled_after_rematching_time",
        "type" => "email",
        "label" => "",
        "title" => "Cancelled after rematching",
        "content" => "【デートチケットを発行しました】\n\n本日のデートは、お相手のご都合によりキャンセルとなったため、デートチケットを発行致しました\n\n振替チケットのご利用はこちら\n https://web.bachelorapp.net/coupon\n\n*有効期限は【２ヶ月】です。\n\n:coupon_return_text\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => "coupon_return_text"
    ],
    [
        "key" => "cancellation_reported_for_male_user",
        "eligible_user_key" => "male_user_cancellation_reported",
        "type" => "email",
        "label" => "",
        "title" => "Cancelled after rematching",
        "content" => "お相手の方から、キャンセルされたと報告がありました。\nそのため、キャンセル料(3000円)を請求しております。\n\n事実と異なる場合、以下のお問い合わせよりご連絡ください。\n https://bachelorapp.zendesk.com/hc/ja/requests/new\n\n※ 尚、ビデオデートを断られた場合は料金は発生しません。\nこちらからお手続きください： https://forms.gle/cyhag8aUMgusADzL6\n\n次回のデートは月曜から予約できます、お楽しみに！\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "cancellation_reported_for_female_user",
        "eligible_user_key" => "female_user_cancellation_reported",
        "type" => "email",
        "label" => "",
        "title" => "Cancelled after rematching",
        "content" => "お相手の方から、キャンセルされたと報告がありました。\nそのため、キャンセル料(3000円)を請求しております。\n\n事実と異なる場合、以下のお問い合わせよりご連絡ください。\n https://bachelorapp.zendesk.com/hc/ja/requests/new\n\n※ 尚、ビデオデートを断られた場合は料金は発生しません。\nこちらからお手続きください： https://forms.gle/cyhag8aUMgusADzL6\n\n次回のデートは月曜から予約できます、お楽しみに！\n\n===\n■ 一部のメールがプロモーション/迷惑フォルダに入ってしまう場合\n https://bul.to/support-mail-setting\n\n■ よくある質問・ヘルプ\n https://bul.to/support-bachelor-m",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "partner_cancel_participate_rematching_for_male_user",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Cancelled participate rematching by partner",
        "content" => "【お相手が変更になります】\nお相手がキャンセルをしたため、新しいお相手を探しています。\n\n当日13時までにマッチング結果をお知らせします。\n(お相手が見つからない場合がございます。その場合、デートチケットが発行されます。)\n\n※他のお相手を希望しない場合、こちらからキャンセルしてください。(当日12時締切)\nweb.bachelorapp.net/",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "partner_cancel_participate_rematching_for_male_user",
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Cancelled participate rematching by partner",
        "content" => "【他のお相手を探しています】 先ほど、お相手がキャンセルしました。他の相手を希望しない場合はこちら /cancel-rematching",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "partner_cancel_participate_rematching_for_female_user",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Cancelled participate rematching by partner",
        "content" => "【お相手が変更になります】\nお相手がキャンセルをしたため、新しいお相手を探しています。\n\n当日13時までにマッチング結果をお知らせします。\n(お相手が見つからない場合がございます。その場合、デートチケットが発行されます。)\n\n※他のお相手を希望しない場合、こちらからキャンセルしてください。(当日12時締切)\nweb.bachelorapp.net/",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "partner_cancel_participate_rematching_for_female_user",
        "eligible_user_key" => "",
        "type" => "sms",
        "label" => "",
        "title" => "Cancelled participate rematching by partner",
        "content" => "【他のお相手を探しています】 先ほど、お相手がキャンセルしました。他の相手を希望しない場合はこちら /cancel-rematching",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => null
    ],
    [
        "key" => "chat_received_for_male_user",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Chat received",
        "content" => "お相手からメッセージが届きました！\n\n確認はこちら: chat_url",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'chat_url'
    ],
    [
        "key" => "chat_received_for_female_user",
        "eligible_user_key" => "",
        "type" => "email",
        "label" => "",
        "title" => "Chat received",
        "content" => "お相手からメッセージが届きました\n\n確認はこちら: chat_url",
        "prefectures" => null,
        "follow_interval" => 0,
        "status" => 1,
        "variables" => 'chat_url'
    ]
];
