<?php

namespace Bachelor\Domain\DatingManagement\ParticipantForRematch\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static PassedRematchTime()
 * @method static AlreadyParticipated()
 * @method static NotAllowedUser()
 */
final class ValidationMessages extends Enum
{
    const PassedRematchTime = [
        'after_rematch_time' => ['12時の締め切りを過ぎたため申請ができません']
    ];
    const AlreadyParticipated = [
        'already_participated' => ['すでに申請済みです']
    ];
    const NotAllowedUser = [
        'not_allowed_user' => ['参加可能なステータスではありません']
    ];
}
