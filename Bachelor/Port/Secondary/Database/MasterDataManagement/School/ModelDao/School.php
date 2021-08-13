<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\School\ModelDao;

use Bachelor\Domain\MasterDataManagement\School\Models\School as SchoolDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\School\Traits\SchoolRelationshipTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends BaseModel
{
    use SchoolRelationshipTrait, HasFactory;

    /**
     * @var string[]
     */
    protected  $hidden = [
        'created_at' ,
        'updated_at' ,
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schools';

    /**
     * @return SchoolDomainModel
     */
    public function toDomainEntity(): SchoolDomainModel
    {
        $school = new SchoolDomainModel(
            $this->school_name,
            $this->education_group,
            (bool)$this->is_selectable,
        );
        $school->setId($this->getKey());

        return $school;
    }

    /**
     * @param SchoolDomainModel $school
     * @return School
     */
    protected function fromDomainEntity($school)
    {
        $this->id = $school->getId();
        $this->school_name = $school->getSchoolName();
        $this->education_group = $school->getEducationGroup();
        $this->is_selectable = $school->isSelectable();

        return $this;
    }
}
