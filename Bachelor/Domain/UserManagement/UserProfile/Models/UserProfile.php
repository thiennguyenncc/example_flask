<?php
namespace Bachelor\Domain\UserManagement\UserProfile\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\MasterDataManagement\School\Models\School;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;

class UserProfile extends BaseDomainModel
{
    private int $userId;
    private ?Carbon $birthDay;
    private ?int $height;
    private ?int $bodyType;
    private ?int $marriageIntention;
    private ?array $character;
    private ?int $smoking;
    private ?int $drinking;
    private ?int $divorce;
    private ?int $annualIncome;
    private ?array $appearanceStrength;
    private ?array $appearanceFeatures;
    private ?int $education;
    private ?School $school;
    private ?string $companyName;
    private ?int $job;
    private ?array $hobby;

    private ?User $user;


    public function __construct(
        int $userId,
        Carbon $birthDay = null,
        int $height = null,
        int $bodyType = null,
        int $marriageIntention = null,
        array $character = null,
        int $smoking = null,
        int $drinking = null,
        int $divorce = null,
        int $annualIncome = null,
        array $appearanceStrength = null,
        array $appearanceFeatures = null,
        int $education = null,
        ?School $school = null,
        string $companyName = null,
        int $job = null,
        array $hobby = null
    )
    {
        $this->setUserId($userId);
        $this->setBirthDay($birthDay);
        $this->setHeight($height);
        $this->setBodyType($bodyType);
        $this->setMarriageIntention($marriageIntention);
        $this->setCharacter($character);
        $this->setSmoking($smoking);
        $this->setDrinking($drinking);
        $this->setDivorce($divorce);
        $this->setAnnualIncome($annualIncome);
        $this->setAppearanceStrength($appearanceStrength);
        $this->setAppearanceFeatures($appearanceFeatures);
        $this->setEducation($education);
        $this->setSchool($school);
        $this->setCompanyName($companyName);
        $this->setJob($job);
        $this->setHobby($hobby);
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->birthDay?->age;
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
     * @return Carbon|null
     */
    public function getBirthDay(): ?Carbon
    {
        return $this->birthDay;
    }

    /**
     * @param Carbon|null $birthDay
     */
    public function setBirthDay(?Carbon $birthDay): void
    {
        $this->birthDay = $birthDay;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     */
    public function setHeight(?int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return int|null
     */
    public function getBodyType(): ?int
    {
        return $this->bodyType;
    }

    /**
     * @param int|null $bodyType
     */
    public function setBodyType(?int $bodyType): void
    {
        $this->bodyType = $bodyType;
    }

    /**
     * @return int|null
     */
    public function getMarriageIntention(): ?int
    {
        return $this->marriageIntention;
    }

    /**
     * @param int|null $marriageIntention
     */
    public function setMarriageIntention(?int $marriageIntention): void
    {
        $this->marriageIntention = $marriageIntention;
    }

    /**
     * @return array|null
     */
    public function getCharacter(): ?array
    {
        return $this->character;
    }

    /**
     * @param array|null $character
     */
    public function setCharacter(?array $character): void
    {
        $this->character = $character;
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
     * @return array|null
     */
    public function getAppearanceStrength(): ?array
    {
        return $this->appearanceStrength;
    }

    /**
     * @param array|null $appearanceStrength
     */
    public function setAppearanceStrength(?array $appearanceStrength): void
    {
        $this->appearanceStrength = $appearanceStrength;
    }

    /**
     * @return array|null
     */
    public function getAppearanceFeatures(): ?array
    {
        return $this->appearanceFeatures;
    }

    /**
     * @param array|null $appearanceFeatures
     */
    public function setAppearanceFeatures(?array $appearanceFeatures): void
    {
        $this->appearanceFeatures = $appearanceFeatures;
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
     * @return School|null
     */
    public function getSchool(): ?School
    {
        return $this->school;
    }

    /**
     * @param School|null $school
     */
    public function setSchool(?School $school): void
    {
        $this->school = $school;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string|null $companyName
     */
    public function setCompanyName(?string $companyName): void
    {
        $this->companyName = $companyName;
    }

    /**
     * @return int|null
     */
    public function getJob(): ?int
    {
        return $this->job;
    }

    /**
     * @param int|null $job
     */
    public function setJob(?int $job): void
    {
        $this->job = $job;
    }

    /**
     * @return array|null
     */
    public function getHobby(): ?array
    {
        return $this->hobby;
    }

    /**
     * @param array|null $hobby
     */
    public function setHobby(?array $hobby): void
    {
        $this->hobby = $hobby;
    }

    /**
     * @param User $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }


    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     *  Update User Profile Information
     *
     * @param array $params
     * @return void
     */
    public function update($params) : void
    {
        $this->setBirthDay($params['birthday']);
        $this->setHeight($params['height']);
        $this->setBodyType($params['bodyType']);
        $this->setMarriageIntention($params['marriageIntention']);
        $this->setCharacter($params['character']);
        $this->setSmoking($params['smoking']);
        $this->setDrinking($params['drinking']);
        $this->setDivorce($params['divorce']);
        $this->setAnnualIncome($params['annualIncome']);
        $this->setAppearanceStrength($params['appearanceStrength']);
        $this->setAppearanceFeatures($params['appearanceFeatures']);
        $this->setEducation($params['education']);
        $this->setSchoolName($params['schoolName']);
        $this->setCompanyName($params['companyName']);
        $this->setJob($params['job']);
        $this->setHobby($params['hobby']);
//        $this->setEducationGroup($params['educationGroup']);
//        $this->setSchoolCode($params['schoolCode']);
    }

    /**
     * @return string
     */
    public function getMatchInfoUrl(): ?string
    {
        return env('WEB_APP_URL') . 'match-info?gender='
            . $this->getUser()?->getGender() . '&age=' . $this->getAge();
    }
}
