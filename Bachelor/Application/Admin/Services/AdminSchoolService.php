<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Domain\MasterDataManagement\School\Interfaces\SchoolRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\School\Models\School;
use Bachelor\Utility\ResponseCodes\ApiCodes;
use Illuminate\Http\Response;

class AdminSchoolService
{
    /**
     * @var SchoolRepositoryInterface
     */
    private $schoolRepository;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data = [];

    /**
     * AdminSchoolService constructor.
     * @param SchoolRepositoryInterface $school
     */
    public function __construct(SchoolRepositoryInterface $schoolRepository)
    {
        $this->schoolRepository = $schoolRepository;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Get All Schools
     *
     * @return Array
     */
    public function getAllSchools($param): array
    {
        $this->data =  $this->schoolRepository->getAllSchools($param['school_name'] ?? "", $param['education_group'] ?? null)->transform(function (School $school) {
            return [
                'id' => $school->getId(),
                'education_group' => $school->getEducationGroup(),
                'school_name' => $school->getSchoolName(),
                'is_selectable' => $school->isSelectable(),
            ];
        })->toArray();
        return $this->handleApiResponse();
    }

    /**
     * Create New School
     *
     * @return Array
     */
    public function createNewSchool(array $param): array
    {
        $newSchool = new School($param['school_name'], $param['education_group'], $param['is_selectable']);
        $this->schoolRepository->save($newSchool);

        return $this->handleApiResponse();
    }

    /**
     * Update exsting School
     *
     * @return Array
     */
    public function updateSchool(int $id, array $param): array
    {

        $school = $this->schoolRepository->getSchoolById($id);
        $school->setSchoolName($param['school_name']);
        $school->setEducationGroup($param['education_group']);
        $school->setIsSelectable($param['is_selectable']);

        $this->schoolRepository->save($school);

        return $this->handleApiResponse();
    }

    /**
     * Delete exsting School
     *
     * @return Array
     */
    public function deleteSchool(int $id): array
    {
        $school = $this->schoolRepository->getSchoolById($id);
        $school->disable();

        $this->schoolRepository->save($school);
        return $this->handleApiResponse();
    }

    /**
     * Format response data
     *
     * @return array
     */
    public function handleApiResponse(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
