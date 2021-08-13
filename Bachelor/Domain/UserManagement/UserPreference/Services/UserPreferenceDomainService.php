<?php

namespace Bachelor\Domain\UserManagement\UserPreference\Services;

use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;
use Bachelor\Domain\PaymentManagement\UserPlan\Enum\UserPlanStatus;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Models\UserPlan;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserPreference\Enums\ValidationMessages;
use Bachelor\Domain\UserManagement\UserPreference\Interfaces\UserPreferenceInterface;
use Bachelor\Domain\UserManagement\UserPreference\Models\UserPreference;
use Exception;

class UserPreferenceDomainService
{

    /**
     * @var UserPreferenceInterface
     */
    private $userPreferenceRepository;

    private UserPlanRepositoryInterface $userPlanRepository;

    /**
     * UserProfileDomainService constructor.
     * @param UserPreferenceInterface $userPreferenceRepository
     * @param UserPlanRepositoryInterface $userPlanRepository
     */
    public function __construct(
        UserPreferenceInterface $userPreferenceRepository,
        UserPlanRepositoryInterface $userPlanRepository
    )
    {
        $this->userPreferenceRepository = $userPreferenceRepository;
        $this->userPlanRepository = $userPlanRepository;
    }

    /**
     * Update User Preference
     *
     * @param int $userId
     * @param array $params
     * @return UserPreference
     * @throws Exception
     */
    public function updatePreference($userId, array $params): UserPreference
    {
        $userPreference = $this->userPreferenceRepository->retrieveUserPreferenceByUserId($userId);
        if ($userPreference) {
            $userPreference->update($params);
            return $this->userPreferenceRepository->save($userPreference);
        }

        throw new Exception(__('api_messages.userPreference.no_user_preference_found'));
    }

    /**
     * Set Age To for user
     *
     * @param User $user
     * @param int $ageTo
     * @return bool
     * @throws Exception
     */
    public function validationAgeTo(User $user, int $ageTo)
    {
        $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
        $userAge = $user->getUserProfile()->getAge();
        
        if ($user->getGender() === UserGender::Male &&
            $userAge >= config('constants.boundary_age_for_age_setting_for_male') &&
            $ageTo <= $userAge - 6
        ) {
            if (is_null($userPlan) || $userPlan->getPlan()->getCostPlan()->getKey() != CostPlan::Premium){
                throw BaseValidationException::withMessages(ValidationMessages::AgeToForPremium);
            }
        }
        return true;
    }

}
