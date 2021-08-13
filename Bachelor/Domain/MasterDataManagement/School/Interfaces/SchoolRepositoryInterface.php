<?php

namespace Bachelor\Domain\MasterDataManagement\School\Interfaces;

use Bachelor\Domain\MasterDataManagement\School\Models\School;
use Bachelor\Domain\MasterDataManagement\School\Models\School as SchoolDomainModel;
use Illuminate\Support\Collection;

interface SchoolRepositoryInterface
{
    /**
     * Get All Schools
     *
     * @return Collection
     */
    public function getAllSchools(string $school_name = "", int $education_group = null): Collection;

    /**
     * Get School By ID
     *
     * @return Array
     */
    public function getSchoolById(int $id): SchoolDomainModel;

    /**
     * save
     *
     * @return School
     */
    public function save(School $school): School;

    /**
     * @param $schoolName
     * @return SchoolDomainModel|null
     */
    public function getSchoolBySchoolName($schoolName): ?School;
}
