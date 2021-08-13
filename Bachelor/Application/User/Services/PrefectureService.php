<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Domain\Base\Condition;
use Bachelor\Domain\Base\Filter;
use Bachelor\Domain\Base\Language\Enums\Languages;
use Bachelor\Domain\MasterDataManagement\Area\Interfaces\AreaRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Area\Model\Area;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Prefecture\Interfaces\PrefectureRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Prefecture\Model\Prefecture;
use Bachelor\Domain\UserManagement\User\Enums\UserFilter;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Utility\Enums\Status;
use Bachelor\Utility\ResponseCodes\ApiCodes;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PrefectureService
{
    /*
     * @var PrefectureRepositoryInterface
     */
    private PrefectureRepositoryInterface $prefectureRepository;

    /*
     * @var AreaRepositoryInterface
     */
    private AreaRepositoryInterface $areaRepository;

    /*
     * @var DatingPlaceRepositoryInterface
     */
    private DatingPlaceRepositoryInterface $datingPlaceRepository;

    /**
     * Response Status
     */
    protected int $status;

    /**
     * Response Message
     */
    protected string $message;

    /*
     * Response data
     * @var array
     */
    protected array $data = [];

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * PrefectureService constructor.
     * @param PrefectureRepositoryInterface $prefectureRepository
     * @param AreaRepositoryInterface $areaRepository
     * @param DatingPlaceRepositoryInterface $datingPlaceRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        PrefectureRepositoryInterface $prefectureRepository,
        AreaRepositoryInterface $areaRepository,
        DatingPlaceRepositoryInterface $datingPlaceRepository,
        UserRepositoryInterface $userRepository,
    ) {
        $this->prefectureRepository = $prefectureRepository;
        $this->areaRepository = $areaRepository;
        $this->datingPlaceRepository = $datingPlaceRepository;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
        $this->userRepository = $userRepository;
    }

    /**
     * Get the prefecture data
     *
     * @param array $params
     * @return self
     */
    public function getPrefectureData(array $params): self
    {
        $this->data = [
            'prefectures' => $this->prefectureRepository->getSpecifiedPrefectures($params)->transform(function ($prefecture) {
                /* @var Prefecture $prefecture */
                return [
                    'id' => $prefecture->getId(),
                    'admin_id' => $prefecture->getAdminId(),
                    'name' => $prefecture->getName(),
                    'status' => $prefecture->getStatus()
                ];
            })
        ];

        return $this;
    }

    /**
     * Get all areas data
     *
     * @return self
     */
    public function getAllAreaData(): self
    {
        $this->data = [
            'areas' => $this->areaRepository->getAll()->toArray()
        ];

        return $this;
    }

    /**
     * Get the area data
     *
     * @param array $params
     * @return self
     */
    public function getAreaData(array $params): self
    {
        if (isset($params['page'])) unset($params['page']);

        $this->data = [
            'areas' => $this->areaRepository->getSpecifiedAreas(['filters' => $params])->transform(function ($area) {
                /* @var Area $area */
                return [
                    'id' => $area->getId(),
                    'prefecture_id' => $area->getPrefecture()->getId(),
                    'name' => $area->getName(),
                    'status' => $area->getStatus()
                ];
            })->toArray()
        ];

        return $this;
    }

    /**
     * Create a new prefecture and obtain updated data
     *
     * @param array $params
     * @return self
     * @throws Exception
     */
    public function createNewPrefecture(array $params): self
    {
        DB::beginTransaction();
        $prefectureDomainModel = new Prefecture(
            $params['nameEn'],
            $params['countryId'],
            Auth::user()->id
        );

        if ($this->prefectureRepository->save($prefectureDomainModel)) {
            foreach (Languages::getValues() as $key => $shortCode) {
                $this->prefectureRepository->updateOrCreatePrefectureTranslation(
                    $prefectureDomainModel,
                    [
                        'name' => $params['name' . Str::ucfirst($shortCode)],
                        'language_id' => $key + 1
                    ]
                );
            }
            $this->message = __('api_messages.prefecture.successfully_created_new_prefecture');
            DB::commit();
            return $this;
        }

        DB::rollBack();

        throw new Exception(__('api_messages.prefecture.unable_to_create_prefecture'));
    }

    /**
     * Create a new area and obtain updated data
     *
     * @param array $params
     * @return self
     * @throws Exception
     */
    public function createNewArea(array $params): self
    {
        DB::beginTransaction();

        $prefectureDomainModel = $this->prefectureRepository->getSpecificPrefecture($params['prefectureId']);

        if ($prefectureDomainModel) {
            $areaDomainModel = new Area(
                $prefectureDomainModel,
                $params['nameEn'],
                null
            );

            if ($this->areaRepository->save($areaDomainModel)) {
                foreach (Languages::getValues() as $key => $shortCode) {
                    $this->areaRepository->updateOrCreatePrefectureTranslation(
                        $areaDomainModel,
                        [
                            'name' => $params['name' . Str::ucfirst($shortCode)],
                            'language_id' => $key + 1
                        ]
                    );
                }
                $this->message = __('api_messages.area.successfully_created_new_area');
                DB::commit();
                return $this;
            }
        } else {
            DB::rollBack();

            throw new Exception(__('api_messages.prefecture.not_found'));
        }

        DB::rollBack();

        throw new Exception(__('api_messages.area.unable_to_create_area'));
    }


    /**
     * Update prefecture data
     *
     * @param int $prefectureId
     * @param array $params
     * @return self
     * @throws Exception
     */
    public function updatePrefecture(int $prefectureId, array $params): self
    {
        DB::beginTransaction();

        $prefectureDomainModel = $this->prefectureRepository->getSpecificPrefecture($prefectureId);

        if ($prefectureDomainModel) {
            $prefectureDomainModel->setAdminId(Auth::user()->id ?? $prefectureDomainModel->getAdminId());
            $prefectureDomainModel->setCountryId($params['countryId'] ?? $prefectureDomainModel->getCountryId());
            $prefectureDomainModel->setName($params['name'] ?? $prefectureDomainModel->getName());
            $prefectureDomainModel->setStatus($params['status'] ?? $prefectureDomainModel->getStatus());

            if ($this->prefectureRepository->save($prefectureDomainModel)) {
                $this->message = __('api_messages.prefecture.successfully_updated_prefecture');
                DB::commit();
                return $this;
            }
        } else {
            DB::rollBack();

            throw new Exception(__('api_messages.prefecture.not_found'));
        }

        DB::rollBack();

        throw new Exception(__('api_messages.prefecture.unable_to_update_prefecture'));
    }

    /**
     * Update area data
     *
     * @param int $areaId
     * @param array $params
     * @return self
     * @throws Exception
     */
    public function updateArea(int $areaId, array $params): self
    {
        DB::beginTransaction();

        $areaDomainModel = $this->areaRepository->getSpecificArea($areaId);

        if ($areaDomainModel) {
            $areaDomainModel->setName($params['name'] ?? $areaDomainModel->getName());
            $areaDomainModel->setStatus($params['status'] ?? $areaDomainModel->getStatus());
            $prefectureDomainModel = $this->prefectureRepository->getSpecificPrefecture($params['prefectureId']);
            $areaDomainModel->setPrefecture($prefectureDomainModel);

            if ($this->areaRepository->save($areaDomainModel)) {
                $this->message = __('api_messages.area.successfully_updated_area');
                DB::commit();
                return $this;
            }
        }

        DB::rollBack();

        throw new Exception(__('api_messages.area.unable_to_update_area'));
    }

    /**
     * Delete prefecture data
     *
     * @param int $prefectureId
     * @param array $params
     * @return self
     * @throws Exception
     */
    public function analyzeAndDeletePrefecture(int $prefectureId, array $params): self
    {
        if (!$params['forceDelete']) {
            if ($this->userRepository->getList(new Filter([
                Condition::make(UserFilter::PrefectureId, $prefectureId)
            ]))->count()) {
                $this->status = ApiCodes::PREFECTURE_IN_USE;
                $this->message = __('api_messages.prefecture.prefecture_in_use');

                return $this;
            }
        }

        $params['status'] = Status::Deleted;
        $this->updatePrefecture($prefectureId, $params);

        return $this;
    }

    /**
     * Delete area data
     *
     * @param int $areaId
     * @return self
     * @throws Exception
     */
    public function analyzeAndDeleteArea(int $areaId): self
    {
        $this->updateArea($areaId, ['status' => Status::Deleted]);

        $this->message = __('api_messages.area.successfully_deleted_area');

        return $this;
    }

    /**
     * Format Registration data
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
