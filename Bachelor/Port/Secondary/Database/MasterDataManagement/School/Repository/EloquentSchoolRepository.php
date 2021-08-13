<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\School\Repository;

use Bachelor\Domain\MasterDataManagement\School\Interfaces\SchoolRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\School\Models\School as SchoolDomainEntity;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\School\ModelDao\School;
use Illuminate\Support\Collection;

class EloquentSchoolRepository extends EloquentBaseRepository implements SchoolRepositoryInterface
{
    /**
     * EloquentSchoolRepository constructor.
     * @param School $school
     */
    public function __construct(School $school)
    {
        parent::__construct($school);
    }

    /**
     * Get All School
     *
     * @return Array
     */
    public function getAllSchools(string $school_name = "", int $education_group = null): Collection
    {
        $query = $this->createQuery();
        if (!empty($school_name)) {
            $query->where('school_name', 'like', '%' . $school_name . '%');
        }
        if (!empty($education_group)) {
            $query->where('education_group', $education_group);
        }
        return $this->transformCollection($query->get());
    }

    /**
     * Get School By ID
     *
     * @return Array
     */
    public function getSchoolById(int $id): SchoolDomainEntity
    {
        $query = $this->createQuery()->find($id);
        if ($query) {
            return $query->toDomainEntity();
        }
        throw new \Exception(__('admin_messages.school_not_found'));
    }

    public function save(SchoolDomainEntity $school): SchoolDomainEntity
    {
        return $this->createModelDAO($school->getId())->saveData($school);
    }

    public function getSchoolBySchoolName($schoolName): ?SchoolDomainEntity
    {
        $school = $this->createQuery()->where('school_name', $schoolName)->first();

        return $school?->toDomainEntity();
    }
}
