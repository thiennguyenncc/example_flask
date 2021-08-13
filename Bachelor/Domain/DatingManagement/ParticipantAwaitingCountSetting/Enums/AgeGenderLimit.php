<?php


namespace Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Enums;


use Bachelor\Utility\Enums\IntEnum;

class AgeGenderLimit extends IntEnum
{
    const MALE_YOUNG_AGE_LIMIT = 28;
    const MALE_OLD_AGE_LIMIT = 40;
    const FEMALE_YOUNG_AGE_LIMIT = 35;
}
