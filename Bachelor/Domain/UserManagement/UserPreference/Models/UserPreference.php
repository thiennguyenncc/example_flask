<?php
namespace Bachelor\Domain\UserManagement\UserPreference\Models;

use Bachelor\Domain\Base\BaseDomainModel;

class UserPreference extends BaseDomainModel
{
    private ?int $userId;
    private ?int $ageFrom;
    private ?int $ageTo;
    private ?int $heightTo;
    private ?int $heightFrom;
    private ?int $partnerBodyMin;
    private ?int $partnerBodyMax;
    private ?int $smoking;
    private ?int $drinking;
    private ?int $divorce;
    private ?int $annualIncome;
    private ?int $education;
    private ?array $job;
    private ?array $facePreferences;
    private ?int $appearancePriority;
    private ?int $firstPriority;
    private ?int $secondPriority;
    private ?int $thirdPriority;
    private ?int $hobby;

    public function __construct(
        int $userId,
        int $ageFrom = null,
        int $ageTo = null,
        int $heightTo = null,
        int $heightFrom = null,
        int $partnerBodyMin = null,
        int $partnerBodyMax = null,
        int $smoking = null,
        int $drinking = null,
        int $divorce = null,
        int $annualIncome = null,
        int $education = null,
        array $job = null,
        array $facePreferences = null,
        int $appearancePriority = null,
        int $firstPriority = null,
        int $secondPriority = null,
        int $thirdPriority = null,
        int $hobby = null
    )
    {
        $this->userId = $userId;
        $this->ageFrom = $ageFrom;
        $this->ageTo = $ageTo;
        $this->heightTo = $heightTo;
        $this->heightFrom = $heightFrom;
        $this->partnerBodyMin = $partnerBodyMin;
        $this->partnerBodyMax = $partnerBodyMax;
        $this->smoking = $smoking;
        $this->drinking = $drinking;
        $this->divorce = $divorce;
        $this->annualIncome = $annualIncome;
        $this->education = $education;
        $this->job = $job;
        $this->facePreferences = $facePreferences;
        $this->appearancePriority = $appearancePriority;
        $this->firstPriority = $firstPriority;
        $this->secondPriority = $secondPriority;
        $this->thirdPriority = $thirdPriority;
        $this->hobby = $hobby;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int|null
     */
    public function getAgeFrom(): ?int
    {
        return $this->ageFrom;
    }

    /**
     * @param int|null $ageFrom
     */
    public function setAgeFrom(?int $ageFrom): void
    {
        $this->ageFrom = $ageFrom;
    }

    /**
     * @return int|null
     */
    public function getAgeTo(): ?int
    {
        return $this->ageTo;
    }

    /**
     * @param int|null $ageTo
     */
    public function setAgeTo(?int $ageTo): void
    {
        $this->ageTo = $ageTo;
    }

    /**
     * @return int|null
     */
    public function getHeightTo(): ?int
    {
        return $this->heightTo;
    }

    /**
     * @param int|null $heightTo
     */
    public function setHeightTo(?int $heightTo): void
    {
        $this->heightTo = $heightTo;
    }

    /**
     * @return int|null
     */
    public function getHeightFrom(): ?int
    {
        return $this->heightFrom;
    }

    /**
     * @param int|null $heightFrom
     */
    public function setHeightFrom(?int $heightFrom): void
    {
        $this->heightFrom = $heightFrom;
    }

    /**
     * @return int|null
     */
    public function getPartnerBodyMin(): ?int
    {
        return $this->partnerBodyMin;
    }

    /**
     * @param int|null $partnerBodyMin
     */
    public function setPartnerBodyMin(?int $partnerBodyMin): void
    {
        $this->partnerBodyMin = $partnerBodyMin;
    }

    /**
     * @return int|null
     */
    public function getPartnerBodyMax(): ?int
    {
        return $this->partnerBodyMax;
    }

    /**
     * @param int|null $partnerBodyMax
     */
    public function setPartnerBodyMax(?int $partnerBodyMax): void
    {
        $this->partnerBodyMax = $partnerBodyMax;
    }

    /**
     * @return int|null
     */
    public function getSmoking(): ?int
    {
        return $this->smoking;
    }

    /**
     * @param int|null $smoking
     */
    public function setSmoking(?int $smoking): void
    {
        $this->smoking = $smoking;
    }

    /**
     * @return int|null
     */
    public function getDrinking(): ?int
    {
        return $this->drinking;
    }

    /**
     * @param int|null $drinking
     */
    public function setDrinking(?int $drinking): void
    {
        $this->drinking = $drinking;
    }

    /**
     * @return int|null
     */
    public function getDivorce(): ?int
    {
        return $this->divorce;
    }

    /**
     * @param int|null $divorce
     */
    public function setDivorce(?int $divorce): void
    {
        $this->divorce = $divorce;
    }

    /**
     * @return int|null
     */
    public function getAnnualIncome(): ?int
    {
        return $this->annualIncome;
    }

    /**
     * @param int|null $annualIncome
     */
    public function setAnnualIncome(?int $annualIncome): void
    {
        $this->annualIncome = $annualIncome;
    }

    /**
     * @return int|null
     */
    public function getEducation(): ?int
    {
        return $this->education;
    }

    /**
     * @param int|null $education
     */
    public function setEducation(?int $education): void
    {
        $this->education = $education;
    }

    /**
     * @return array|null
     */
    public function getJob(): ?array
    {
        return $this->job;
    }

    /**
     * @param array|null $job
     */
    public function setJob(?array $job): void
    {
        $this->job = $job;
    }

    /**
     * @return array|null
     */
    public function getFacePreferences(): ?array
    {
        return $this->facePreferences;
    }

    /**
     * @param array|null $facePreferences
     */
    public function setFacePreferences(?array $facePreferences): void
    {
        $this->facePreferences = $facePreferences;
    }

    /**
     * @return int|null
     */
    public function getAppearancePriority(): ?int
    {
        return $this->appearancePriority;
    }

    /**
     * @param int|null $appearancePriority
     */
    public function setAppearancePriority(?int $appearancePriority): void
    {
        $this->appearancePriority = $appearancePriority;
    }

    /**
     * @return int|null
     */
    public function getFirstPriority(): ?int
    {
        return $this->firstPriority;
    }

    /**
     * @param int|null $firstPriority
     */
    public function setFirstPriority(?int $firstPriority): void
    {
        $this->firstPriority = $firstPriority;
    }

    /**
     * @return int|null
     */
    public function getSecondPriority(): ?int
    {
        return $this->secondPriority;
    }

    /**
     * @param int|null $secondPriority
     */
    public function setSecondPriority(?int $secondPriority): void
    {
        $this->secondPriority = $secondPriority;
    }

    /**
     * @return int|null
     */
    public function getThirdPriority(): ?int
    {
        return $this->thirdPriority;
    }

    /**
     * @param int|null $thirdPriority
     */
    public function setThirdPriority(?int $thirdPriority): void
    {
        $this->thirdPriority = $thirdPriority;
    }

    /**
     * @return int|null
     */
    public function getHobby(): ?int
    {
        return $this->hobby;
    }

    /**
     * @param int|null $hobby
     */
    public function setHobby(?int $hobby): void
    {
        $this->hobby = $hobby;
    }



    /**
     *  Update User Preference Information
     *
     * @param array $params
     * @return void
     */
    public function update($params) : void
    {
        $this->setAgeFrom($params['ageFrom']);
        $this->setAgeTo($params['ageTo']);
        $this->setHeightTo($params['heightTo']);
        $this->setHeightFrom($params['heightFrom']);
        $this->setPartnerBodyMin($params['partnerBodyMin']);
        $this->setPartnerBodyMax($params['partnerBodyMax']);
        $this->setSmoking($params['smoking']);
        $this->setDrinking($params['drinking']);
        $this->setDivorce($params['divorce']);
        $this->setAnnualIncome($params['annualIncome']);
        $this->setEducation($params['education']);
        $this->setJob($params['job']);
        $this->setFacePreferences($params['facePreferences']);
        $this->setAppearancePriority($params['appearancePriority']);
        $this->setFirstPriority($params['firstPriority']);
        $this->setSecondPriority($params['secondPriority']);
        $this->setThirdPriority($params['thirdPriority']);
        $this->setHobby($params['hobby']);
    }
}

