<?php


namespace Bachelor\Domain\UserManagement\User\Enums;

use BenSampo\Enum\Enum;

final class ValidationMessages extends Enum
{
    // TODO update correct japanese word
    const InvalidStatus = [
        'invalid_status' => ['ステータスが無効です']
    ];
    const UserHasUnpaidInvoice = [
        'user_has_unpaid_invoice' => ['ユーザーが未払いの請求書を持っている']
    ];

    const UserDontHaveTrial = [
        'user_do_not_have_trial' => ['無料期間ではありません']
    ];
    const UserPaidDontHaveSuccessDate = [
        'user_paid_dont_have_success_date' => ['過去に成功デートがありません']
    ];
    const UserDontHaveCard = [
        'user_dont_have_card' => ['カードがありません']
    ];
    const UserHasTrialActive = [
        'user_have_trial_already' => ['すでに無料期間中です']
    ];
    const UserHaveSubscription = [
        'user_have_subscription' => ['現在有料期間中です']
    ];
    const InvalidCostPlan = [
        'invalid_cost_plan' => ['料金プランが無効です']
    ];

}
