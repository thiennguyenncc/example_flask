<?php
namespace Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MatchInfoGroup extends BaseDomainModel
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $ageFrom;

    /**
     * @var int
     */
    private int $ageTo;

    /**
     * @var int
     */
    private int $gender;

    /**
     * @var Collection
     */
    private Collection $matchInfos;

    /**
     * Match Info Group constructor.
     *
     * @param string $name
     * @param string $textAlign
     * @param int $ageFrom
     * @param int $ageTo
     * @param int $gender
     * @param Collection $matchInfo
     */
    public function __construct(
        string $name,
        int $ageFrom,
        int $ageTo,
        int $gender,
        Collection $matchInfos
    ) {
        $this->setName($name);
        $this->setAgeFrom($ageFrom);
        $this->setAgeTo($ageTo);
        $this->setGender($gender);
        $this->setMatchInfos($matchInfos);
    }

    /**
     * Set value for name
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set value for text align
     *
     * @param string $textAlign
     */
    public function setTextAlign(string $textAlign): void
    {
        $this->textAlign = $textAlign;
    }

    /**
     * Get value of text align
     *
     * @return string
     */
    public function getTextAlign(): string
    {
        return $this->textAlign;
    }

    /**
     * Set value for age from
     *
     * @param int $ageFrom
     */
    public function setAgeFrom(int $ageFrom): void
    {
        $this->ageFrom = $ageFrom;
    }

    /**
     * Get value of age from
     *
     * @return int
     */
    public function getAgeFrom(): int
    {
        return $this->ageFrom;
    }

    /**
     * Set value for age to
     *
     * @param int $ageTo
     */
    public function setAgeTo(int $ageTo): void
    {
        $this->ageTo = $ageTo;
    }

    /**
     * Get value of age to
     *
     * @return int
     */
    public function getAgeTo(): int
    {
        return $this->ageTo;
    }

    /**
     * Set value for gender
     *
     * @param int $gender
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * Get value of gender
     *
     * @return int
     */
    public function getGender(): int
    {
        return $this->gender;
    }

    /**
     * @param Collection $matchInfos
     */
    public function setMatchInfos(Collection $matchInfos): void
    {
        $this->matchInfos = $matchInfos;
    }

    /**
     * @return Collection
     */
    public function getMatchInfos(): Collection
    {
        return $this->matchInfos;
    }

    /**
     * @param Collection $matchInfos
     */
    public function updateMatchInfoById(int $id, string $description, string $image): void
    {
        $infos = $this->matchInfos;
        $infos->each(function (MatchInfo $info) use ($id, $description, $image) {
            if ($info->getId() == $id) {
                $info->setDescription($description);
                $info->setImage($image);
            }
        });

        $this->setMatchInfos($infos);
    }
}
