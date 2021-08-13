<?php

namespace Bachelor\Domain\MasterDataManagement\School\Services;

use Bachelor\Domain\MasterDataManagement\School\Interfaces\SchoolRepositoryInterface;

class SchoolDomainService
{
    /**
     * @var SchoolRepositoryInterface
     */
    protected $schoolRepository;

    /**
     * DatingDetailRepository constructor.
     * @param SchoolRepositoryInterface $schoolRepository
     */
    public function __construct(SchoolRepositoryInterface $schoolRepository)
    {
        $this->schoolRepository = $schoolRepository;
    }
}
