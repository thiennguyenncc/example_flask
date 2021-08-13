<?php

namespace Bachelor\Domain\UserManagement\User\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\MasterDataManagement\Prefecture\Model\Prefecture;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Models\UserTrial;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\UserInvitation\Models\UserInvitation;
use Bachelor\Domain\UserManagement\UserPreference\Models\UserPreference;
use Bachelor\Domain\UserManagement\UserInfoUpdatedTime\Models\UserInfoUpdatedTime;
use Bachelor\Domain\UserManagement\UserProfile\Models\UserProfile;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 *
 */
class User extends BaseDomainModel
{
    private ?string $name;

    private ?string $email;

    private ?int $gender = null;

    private ?string $mobileNumber;

    private int $status;

    private ?float $bRate;

    private ?int $registrationSteps = null;

    private ?int $prefectureId = null;

    private float $teamMemberRate;

    private float $flexPoint;

    private bool $isFake;

    private ?string $supportTrackingUrl;

    private ?string $lpQueryStr;

    private ?UserPaymentCustomer $userPaymentCustomer;

    private ?UserProfile $userProfile;

    private ?UserPreference $userPreference;

    private ?UserInfoUpdatedTime $userInfoUpdatedTime;

    private ?UserInvitation $userInvitation;

    private ?Prefecture $prefecture;

    private bool $registrationCompleted = false;

    private ?Collection $userImagesCollection = null;

    private ?Collection $userPreferredAreasCollection = null;

    public function __construct(
        ?string $name,
        ?string $email,
        ?int $gender,
        ?string $mobileNumber,
        int $status,
        ?float $bRate,
        ?int $registrationSteps,
        ?int $prefectureId,
        float $teamMemberRate,
        float $flexPoint,
        bool $isFake,
        ?string $supportTrackingUrl = "",
        ?string $lpQueryStr = null,
        ?UserPaymentCustomer $userPaymentCustomer = null,
        ?UserInfoUpdatedTime $userInfoUpdatedTime = null
    ) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setGender($gender);
        $this->setMobileNumber($mobileNumber);
        $this->setStatus($status);
        $this->setBRate($bRate);
        $this->setRegistrationSteps($registrationSteps);
        $this->setPrefectureId($prefectureId);
        $this->setSupportTrackingUrl($supportTrackingUrl);
        $this->setTeamMemberRate($teamMemberRate);
        $this->setFlexPoint($flexPoint);
        $this->setIsFake($isFake);
        $this->setLpQueryStr($lpQueryStr);
        $this->setUserPaymentCustomer($userPaymentCustomer);
        $this->setUserInfoUpdatedTime($userInfoUpdatedTime);
    }


    public function deactivateAccount(): self
    {
        if (!in_array($this->getStatus(), [UserStatus::ApprovedUser])) {
            throw BaseValidationException::withMessages([
                'cant_deactivate_account' => [__("api_messages.cancel_deactivate_account.cant_deactivate_account")]
            ]);
        }
        $this->setStatus(UserStatus::DeactivatedUser);
        return $this;
    }

    public function cancelAccount(): self
    {
        if (!in_array($this->status, [UserStatus::ApprovedUser, UserStatus::DeactivatedUser])) {
            throw BaseValidationException::withMessages([
                'cant_cancel_account' => [__("api_messages.cancel_deactivate_account.cant_cancel_account")]
            ]);
        }
        $this->setStatus(UserStatus::CancelledUser);
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param ?string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return ?string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param ?string $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int|null
     */
    public function getGender(): ?int
    {
        return $this->gender;
    }

    /**
     * @return string|null
     */
    public function getGenderStr(): ?string
    {
        if ($this->gender == UserGender::Female) {
            return UserGender::Female()->toString();
        } elseif ($this->gender == UserGender::Male) {
            return UserGender::Male()->toString();
        }

        return null;
    }

    /**
     * @param int|null $gender
     */
    public function setGender(?int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    /**
     * @param string|null $mobileNumber
     */
    public function setMobileNumber(?string $mobileNumber): void
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    private function setStatus(int $status): void
    {
        if (!in_array($status, UserStatus::asArray())) {
            throw BaseValidationException::withMessages([
                'user_status_not_found' => [__('admin_messages.user_status_not_found')]
            ]);
        }

        $this->status = $status;
    }

    /**
     * @return float
     */
    public function getBRate(): float
    {
        return $this->bRate;
    }

    /**
     * @param float $bRate
     * @return void
     */
    public function setBRate(?float $bRate): void
    {
        $this->bRate = $bRate;
    }

    /**
     * @return ?int
     */
    public function getRegistrationSteps(): ?int
    {
        return $this->registrationSteps;
    }

    /**
     * @param ?int $registrationSteps
     */
    public function setRegistrationSteps(?int $registrationSteps): void
    {
        if($this->getRegistrationSteps() < $registrationSteps || $this->getRegistrationSteps() == null) {
            $this->registrationSteps = $registrationSteps;
        }
        if ($this->registrationSteps === RegistrationSteps::StepFinal) $this->registrationCompleted = true;
    }

    /**
     * @return int|null
     */
    public function getPrefectureId(): ?int
    {
        return $this->prefectureId;
    }

    /**
     * @param int|null $prefectureId
     */
    public function setPrefectureId(?int $prefectureId): void
    {
        $this->prefectureId = $prefectureId;
    }


    /**
     * @return string|null
     */
    public function getSupportTrackingUrl(): ?string
    {
        return $this->supportTrackingUrl;
    }

    /**
     * @param string|null $supportTrackingUrl
     */
    public function setSupportTrackingUrl(?string $supportTrackingUrl = ""): void
    {
        $this->supportTrackingUrl = $supportTrackingUrl;
    }

    /**
     * @return float
     */
    public function getTeamMemberRate(): float
    {
        return $this->teamMemberRate;
    }

    /**
     * @param float $teamMemberRate
     */
    public function setTeamMemberRate(float $teamMemberRate): void
    {
        $this->teamMemberRate = $teamMemberRate;
    }

    /**
     * @return float
     */
    public function getFlexPoint(): float
    {
        return $this->flexPoint;
    }

    /**
     * @param float $flexPoint
     */
    public function setFlexPoint(float $flexPoint): void
    {
        $this->flexPoint = $flexPoint;
    }

    /**
     * @return bool
     */
    public function isFake(): bool
    {
        return $this->isFake;
    }

    /**
     * @param bool $isFake
     */
    public function setIsFake(bool $isFake): void
    {
        $this->isFake = $isFake;
    }

    /**
     * @return string
     */
    public function getLpQueryStr(): ?string
    {
        return $this->lpQueryStr;
    }

    /**
     * @param string $lpQueryStr
     * @return self
     */
    public function setLpQueryStr(?string $lpQueryStr): self
    {
        $this->lpQueryStr = $lpQueryStr;
        return $this;
    }

    /**
     * Get the value of userPaymentCustomer
     */
    public function getUserPaymentCustomer(): ?UserPaymentCustomer
    {
        return $this->userPaymentCustomer;
    }

    /**
     * Set the value of userPaymentCustomer
     *
     * @param  UserPaymentCustomer|null
     */
    public function setUserPaymentCustomer(?UserPaymentCustomer $userPaymentCustomer): void
    {
        $this->userPaymentCustomer = $userPaymentCustomer;
    }

    /**
     * Get the value of UserInfoUpdatedTime
     */
    public function getUserInfoUpdatedTime(): ?UserInfoUpdatedTime
    {
        return $this->userInfoUpdatedTime;
    }

    /**
     * Set the value of UserInfoUpdatedTime
     *
     * @param UserInfoUpdatedTime|null $userInfoUpdatedTime
     */
    public function setUserInfoUpdatedTime(?UserInfoUpdatedTime $userInfoUpdatedTime): void
    {
        $this->userInfoUpdatedTime = $userInfoUpdatedTime;
    }

    /**
     * @return  bool
     */
    public function getRegistrationCompleted(): bool
    {
        return $this->registrationCompleted;
    }

    /**
     * @return UserPreference|null
     */
    public function getUserPreference(): ?UserPreference
    {
        return $this->userPreference;
    }

    /**
     * @param UserPreference|null $userPreference
     */
    public function setUserPreference(?UserPreference $userPreference): void
    {
        $this->userPreference = $userPreference;
    }

    /**
     * @return UserProfile|null
     */
    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

    /**
     * @param ?UserProfile $userProfile
     */
    public function setUserProfile(?UserProfile $userProfile): void
    {
        $this->userProfile = $userProfile;
    }


    /**
     * @return ?Collection
     */
    public function getUserImagesCollection(): ?Collection
    {
        return $this->userImagesCollection;
    }

    /**
     * @param ?Collection $userImagesCollection
     */
    public function setUserImagesCollection(?Collection $userImagesCollection): void
    {
        $this->userImagesCollection = $userImagesCollection;
    }

    /**
     * @return ?Collection
     */
    public function getUserPreferredAreasCollection(): ?Collection
    {
        return $this->userPreferredAreasCollection;
    }

    /**
     * @param ?Collection $userPreferredAreasCollection
     */
    public function setUserPreferredAreasCollection(?Collection $userPreferredAreasCollection): void
    {
        $this->userPreferredAreasCollection = $userPreferredAreasCollection;
    }

    /**
     * Get the value of UserInvitation
     */
    public function getUserInvitation(): ?UserInvitation
    {
        return $this->userInvitation;
    }

    /**
     * Set the value of UserInvitation
     *
     * @param UserInvitation|null $userInvitation
     */
    public function setUserInvitation(?UserInvitation $userInvitation): void
    {
        $this->userInvitation = $userInvitation;
    }

    /**
     * Get the value of Prefecture
     */
    public function getPrefecture(): ?Prefecture
    {
        return $this->prefecture;
    }

    /**
     * Set the value of Prefecture
     *
     * @param Prefecture|null $prefecture
     */
    public function setPrefecture(?Prefecture $prefecture): void
    {
        $this->prefecture = $prefecture;
    }

    /**
     * @return $this
     * @throws BaseValidationException
     */
    public function setAwaiting(): self
    {
        if ($this->status != UserStatus::IncompleteUser) {
            throw BaseValidationException::withMessages([
                'invalid_status' => [__('api_messages.invalid_status')]
            ]);
        }

        $this->setStatus(UserStatus::AwaitingUser);
        return $this;
    }

    /**
     * @return $this
     * @throws BaseValidationException
     */
    public function cancelAwaiting(): self
    {
        if ($this->status != UserStatus::AwaitingUser) {
            throw BaseValidationException::withMessages([
                'invalid_status' => [__('api_messages.invalid_status')]
            ]);
        }

        $this->setStatus(UserStatus::IncompleteUser);
        return $this;
    }

    /**
     * @return self
     * @throws Exception
     */
    public function approve(): self
    {
        if (!in_array($this->status, [
            UserStatus::AwaitingUser,
            UserStatus::DeactivatedUser,
            UserStatus::CancelledUser
        ])) {
            throw BaseValidationException::withMessages([
                'invalid_status' => [__('api_messages.invalid_status')]
            ]);
        }
        $this->userInfoUpdatedTime?->setApprovedAt(Carbon::now());

        $this->setStatus(UserStatus::ApprovedUser);

        return $this;
    }

    /**
     *  generate unique user id
     *
     * @return string
     *
     */
    public function getUniqueIdByUserAndTime(): string
    {
        return strtotime(Carbon::now()) . $this->getId();
    }

    /**
     * @param string|null $mid
     * @return string|null
     */
    public function getUrlForAfiB(?string $mid = null): ?string
    {
        $lpQueryArr = [];
        parse_str($this->getLpQueryStr(), $lpQueryArr);

        if (!array_key_exists('abm', $lpQueryArr)) {
            Log::error('no abm', ['user_id' => $this->getId()]);
            return null;
        }

        $uniqueId = $this->getUniqueIdByUserAndTime();
        $base = config('measurement.affiliate.afi_b_url') . $uniqueId . '?abm=' . $lpQueryArr['abm'];

        return $mid ? $base . '&mid=' . $mid : $base;
    }

    /**
     * @return string|null
     */
    public function getUrlForXApi(): ?string
    {
        $lpQueryArr = [];
        parse_str($this->getLpQueryStr(), $lpQueryArr);


        if (!array_key_exists('cxsid', $lpQueryArr)) {
            Log::error('no cxsid', ['user_id' => $this->getId()]);
            return null;
        }
        if (!array_key_exists('ma_campaign_id', $lpQueryArr)) {
            Log::error('no ma campaign id', ['user_id' => $this->getId()]);
            return null;
        }

        $uniqueId = $this->getUniqueIdByUserAndTime();

        $base = config('measurement.affiliate.x_api_url') . '?session_id=' . $lpQueryArr['cxsid']
            . '&ma_campaign_id=' . $lpQueryArr['ma_campaign_id']
            . '&oid=' . $uniqueId;

        return $base ? $base : '';
    }

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->status == UserStatus::ApprovedUser;
    }

    /**
     * @param User $user
     * @param Subscription|null $subscription
     * @param UserTrial|null $userTrial
     * @return string
     */
    public function getTrialStatusOrPaid(?Subscription $subscription, ?UserTrial $userTrial): string
    {
        if ($this->getGender() === UserGender::Male) {
            if ($subscription) {
                return 'Paid';
            }

            switch ($userTrial?->getStatus()) {
                case TrialStatus::Completed:
                    return 'Paid';
                case TrialStatus::TempCancelled:
                    return 'TempCancelled';
                case TrialStatus::Active:
                    return 'Trial';
            }
        }

        return 'Free';
    }
}
