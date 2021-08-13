<?php

namespace Bachelor\Domain\UserManagement\UserProfile\Services;

use Bachelor\Domain\MasterDataManagement\School\Interfaces\SchoolRepositoryInterface;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;
use Bachelor\Domain\UserManagement\UserProfile\Models\UserProfile;
use Exception;

class UserProfileDomainService
{

    /**
     * @var UserProfileInterface
     */
    private $userProfileRepository;

    private SchoolRepositoryInterface $schoolRepository;

    /**
     * UserProfileDomainService constructor.
     * @param UserProfileInterface $userProfileRepository
     */
    public function __construct (
        UserProfileInterface $userProfileRepository,
        SchoolRepositoryInterface $schoolRepository
    )
    {
        $this->userProfileRepository = $userProfileRepository;
        $this->schoolRepository = $schoolRepository;
    }

    /**
     * Update User Profile
     *
     * @param int $userId
     * @param array $params
     * @return UserProfile
     * @throws Exception
     */
    public function updateProfile ( $userId , array $params ): UserProfile
    {
        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($userId);
        if($userProfile) {
            $userProfile->update($params);
            return $this->userProfileRepository->save($userProfile);
        }

        throw new Exception(__('api_messages.userProfile.no_user_profile_found'));
    }
}
