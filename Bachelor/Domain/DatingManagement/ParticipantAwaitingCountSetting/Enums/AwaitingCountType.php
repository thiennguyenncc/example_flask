<?php


namespace Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Enums;


use Bachelor\Utility\Enums\StringEnum;

class AwaitingCountType extends StringEnum
{
    const AwaitingYoung = 'awaiting_young';
    const AwaitingMiddle = 'awaiting_middle';
    const AwaitingOld = 'awaiting_old';
    const ApprovedBefore24hYoung = 'approved_before_24h_young';
    const ApprovedBefore24hMiddle = 'approved_before_24h_middle';
    const ApprovedBefore24hOld = 'approved_before_24h_old';
    const ApprovedAfter24hYoung = 'approved_after_24h_young';
    const ApprovedAfter24hMiddle = 'approved_after_24h_middle';
    const ApprovedAfter24hOld = 'approved_after_24h_old';
}
