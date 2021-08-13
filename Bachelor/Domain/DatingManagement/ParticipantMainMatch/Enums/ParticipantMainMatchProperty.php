<?php


namespace Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums;


use Bachelor\Utility\Enums\IntEnum;

class ParticipantMainMatchProperty extends IntEnum
{
    const UserId  = 'userId';
    const User  = 'user';
    const UserInfoUpdatedTime = 'user.userInfoUpdatedTime';
    const UserProfile = 'user.userProfile';
    const DatingDay  = 'datingDay';
    const Id = 'id';
}
