<?php

namespace Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Awaiting()
 * @method static static Unmatched()
 * @method static static Matched()
 * @method static static Cancelled()
 * @method static static Expired()
 */
final class ParticipantMainValidationMessages extends Enum
{
    const UserEmailEmpty = [
        'user_email_empty' => ['Eメールの登録が必須です']
    ];
    const PrefectureDeactivated = [
        'prefecture_deactivated' => ['現在ご登録のエリアは\n参加を受け付けていません']
    ];
}
