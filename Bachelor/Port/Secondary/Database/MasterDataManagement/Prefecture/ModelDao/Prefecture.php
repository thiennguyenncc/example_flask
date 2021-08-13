<?php
namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\Factories\PrefectureFactory;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\Traits\PrefectureRelationshipTrait;
use Bachelor\Domain\MasterDataManagement\Prefecture\Model\Prefecture as PrefectureDomainModel;
use Illuminate\Support\Collection;

class Prefecture extends BaseModel
{
    use PrefectureRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prefectures';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'prefectureTranslation',
        'area'
    ];

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity()
    {
        $prefecture = new PrefectureDomainModel(
            $this->name,
            $this->country_id,
            $this->admin_id,
            $this->status,
        );
        $prefecture->setId($this->getKey());
        if($this->prefectureTranslation()->first()) {
            $prefecture->setPrefectureTranslation($this->prefectureTranslation()->first()->toDomainEntity());
        }
        return $prefecture;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     *
     * @param PrefectureDomainModel $prefecture
     * @return Prefecture
     */
    protected function fromDomainEntity($prefecture)
    {
        $this->id = $prefecture->getId();
        $this->name = $prefecture->getName();
        $this->country_id = $prefecture->getCountryId();
        $this->status = $prefecture->getStatus();
        $this->admin_id = $prefecture->getAdminId();

        return $this;
    }

    /**
     * Get a new factory instance for the model.
     *
     * @param  mixed  $parameters
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function factory(...$parameters)
    {
        return (new PrefectureFactory())
            ->count(is_numeric($parameters[0] ?? null) ? $parameters[0] : null)
            ->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }
}
