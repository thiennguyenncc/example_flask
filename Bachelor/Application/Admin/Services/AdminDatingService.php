<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Application\Admin\Services\Interfaces\AdminDatingServiceInterface;
use Bachelor\Application\Admin\Traits\DatingDataFormatterTrait;
use Bachelor\Application\Admin\Traits\RematchingImportFormatter;
use Bachelor\Application\User\Services\DatingPlaceService;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingUserProperty;
use Bachelor\Domain\DatingManagement\DatingDay\Enums\DatingDayOfWeek;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\DatingManagement\Dating\Models\DatingUser;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Interfaces\ParticipationOpenExpirySettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Model\ParticipationOpenExpirySetting;
use Bachelor\Domain\DatingManagement\Matching\Services\MatchingDomainService;
use Bachelor\Domain\MasterDataManagement\Area\Interfaces\AreaRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Services\UserDomainService;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * @TODO: move DatingDay to different application service
 */
class AdminDatingService implements AdminDatingServiceInterface
{
    use RematchingImportFormatter, DatingDataFormatterTrait;

    /**
     * @var DatingDomainService
     */
    private $datingService;

    /**
     * @var DatingRepositoryInterface
     */
    private $datingRepository;

    /**
     * @var MatchingDomainService
     */
    private $matchingService;

    /**
     * @var ParticipationOpenExpirySettingRepositoryInterface
     */
    private $participationOpenExpirySettingRepository;

    /**
     * @var UserDomainService
     */
    private $userService;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var DatingPlaceService
     */
    private $datingPlaceService;

    /**
     * @var DatingPlaceRepositoryInterface
     */
    private $datingPlaceReponsitory;

    /**
     *
     * @var DatingDayRepositoryInterface
     */
    private $datingDayRepository;
    /**
     *
     * @var AreaRepositoryInterface
     */
    private $areaRepository;

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
     * AdminDatingService constructor.
     * @param DatingDomainService $datingService
     * @param DatingRepositoryInterface $datingRepository
     * @param MatchingDomainService $matchingService
     * @param UserDomainService $userService
     * @param ParticipationOpenExpirySettingRepositoryInterface $participationOpenExpirySettingRepository
     * @param UserRepositoryInterface $userRepository
     * @param DatingPlaceService $datingPlaceService
     * @param DatingPlaceRepositoryInterface $datingPlaceReponsitory
     * @param DatingDayRepositoryInterface $datingDayRepository
     * @param AreaRepositoryInterface $areaRepository
     *
     */
    public function __construct(
        DatingDomainService $datingService,
        DatingRepositoryInterface $datingRepository,
        MatchingDomainService $matchingService,
        UserDomainService $userService,
        ParticipationOpenExpirySettingRepositoryInterface $participationOpenExpirySettingRepository,
        UserRepositoryInterface $userRepository,
        DatingPlaceService $datingPlaceService,
        DatingPlaceRepositoryInterface $datingPlaceReponsitory,
        DatingDayRepositoryInterface $datingDayRepository,
        AreaRepositoryInterface $areaRepository
    ) {
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
        $this->datingService = $datingService;
        $this->datingRepository = $datingRepository;
        $this->matchingService = $matchingService;
        $this->userService = $userService;
        $this->participationOpenExpirySettingRepository = $participationOpenExpirySettingRepository;
        $this->userRepository = $userRepository;
        $this->datingPlaceService = $datingPlaceService;
        $this->datingPlaceReponsitory = $datingPlaceReponsitory;
        $this->datingDayRepository = $datingDayRepository;
        $this->areaRepository = $areaRepository;
    }

    /**
     * 12pm, 3pm rematching from csv file
     *
     * @param string $filePath
     * @return AdminDatingServiceInterface
     */
    public function rematchFromFile($filePath): AdminDatingServiceInterface
    {
        $importData = $this->matchingService->importRematchingCsv($filePath);
        $importData = $this->validateAndFormatImportData($importData);

        $this->data['aborted'] = $importData['invalid'];
        $importedData = $this->matchingService->insertRematching($importData['valid']);

        $this->data['imported'] = count($importedData['success']);
        $this->data['failed_import'] = count($importedData['failure']);

        return $this;
    }

    //match user pair list

    /**
     * Get dating history by week offset (in the past)
     *
     * @param int|null $weekOffSet 0 = this week, -1 = last week, -2 = last last week and so on
     * @param int|null $status
     * @param string|null $search
     * @param int|null $isFake
     * @param string|null $datingDate
     * @param string|null $startTime
     * @return AdminDatingServiceInterface
     */
    public function getDatingHistory(?int $weekOffset = 4, ?int $status = null, ?string $search = "", ?int $isFake = null, ?string $datingDate = null, ?string $startTime = null): AdminDatingServiceInterface
    {
        $from = Carbon::now()->startOfWeek();
        $to = Carbon::now()->addWeeks($weekOffset)->endOfWeek();
        $with = ['datingDay','datingUsers', 'datingUsers.user', 'datingPlace','datingPlace.datingPlaceTranslation', 'datingPlace.area', 'datingPlace.area.areaTranslation'];
        $datesHistory = $this->datingRepository->getDatingsFromTo($from, $to, $status, $with, $search, $isFake, $datingDate, $startTime);
        $userDates = [];
        $num = 1;
        foreach ($datesHistory as $date) {
            $end_time = new Carbon($date->getStartAt());
            //get user dating information without
            $datingMaleUser = $date->getDatingUserByGender(UserGender::Male);
            $datingFemaleUser = $date->getDatingUserByGender(UserGender::Female);
            $maleUserInfo = $datingMaleUser != null ? $datingMaleUser->getUser() : null;
            $femaleUserInfo = $datingFemaleUser != null ? $datingFemaleUser->getUser() : null;

            $datingPlace = $this->datingPlaceReponsitory->getSpecificDatingPlace($date->getDatingPlaceId());
            $datingCafeNearTrainStation = $this->datingPlaceReponsitory->getThreeDatingPlaceByTrainStationId($datingPlace->getTrainStationId(), 'cafe');
            $datingCafeNearTrainStationData = [];
            if ($datingCafeNearTrainStation->isNotEmpty()) {
                foreach ($datingCafeNearTrainStation as $datingCafe) {
                    $datingCafeNearTrainStationData[] = $datingCafe->getDatingPlaceTranslation()->getName();
                }
            }
            $area = $datingPlace != null ? $this->areaRepository->getSpecificArea($datingPlace->getAreaId()) : null;
            $item = [];
            $item['no'] = $num;
            $item['dating_id'] = $date->getId();
            $item['female_is_fake'] = $femaleUserInfo?->isFake() == 0 ? false : true;
            $item['male_name'] = $maleUserInfo?->getName();
            $item['male_id'] = $maleUserInfo?->getId();
            $item['female_name'] = $femaleUserInfo?->getName();
            $item['female_id'] = $femaleUserInfo?->getId();
            $item['dating_place'] = $area?->getAreaTranslation()?->getName();
            $item['dating_cafe'] = $datingPlace->getDatingPlaceTranslation()?->getName();
            $item['dating_cafe_near_train_station'] = !empty($datingCafeNearTrainStationData) ? implode(', ', $datingCafeNearTrainStationData) : '';
            $item['dating_date'] = $date->getDatingDay()->getDatingDate();
            $item['dating_day'] = $date->getDatingDay()->getDatingDayOfWeek();
            $item['dating_time'] = $date->getStartAt();
            $item['dating_end_time'] = $end_time->addHour(1)->format('H:i');
            $item['coupon_activated'] = '';
            $item['female_cafes_blacklist'] = '';
            $item['male_cafes_blacklist'] = '';
            $num++;
            $userDates[] = $item;
        }
        $this->data = $userDates;
        return $this;
    }

    /**
     * create dating data
     *
     * @param array $data format [
     * 'maleUserPreferredPlaces' => ['area_id' -> int],
     * 'femaleUserPreferredPlaces' => ['area_id' => int],
     * 'dating_day_id' => int,
     * 'time' => string, 'dating_place_id' => int,
     * 'male' => int, 'female' => int]
     * @return $this
     */
    public function createDating(array $data): AdminDatingServiceInterface
    {
        $formatParams = $this->getFormattedDataForDating($data);
        DB::beginTransaction();
        try {
            $maleUser = $this->userRepository->getById($formatParams['datingMaleUser']['user_id']);
            $femaleUser = $this->userRepository->getById($formatParams['datingFemaleUser']['user_id']);
            $maleValidate = $this->datingService->isDuplicatedOnSameDatingDay($maleUser, $formatParams['dating']['dating_day_id']);
            $femaleValidate = $this->datingService->isDuplicatedOnSameDatingDay($femaleUser, $formatParams['dating']['dating_day_id']);
            if (!$maleValidate || !$femaleValidate) {
                $this->status = 512;
                if (!$maleValidate) {
                    $this->message = __('api_messages.dating_male_user_already_exist_dating_in_this_dating_day');
                }
                if (!$femaleValidate) {
                    $this->message = __('api_messages.dating_female_user_already_exist_dating_in_this_dating_day');
                }
                if (!$maleValidate && !$femaleValidate) {
                    $this->message = __('api_messages.dating_male_and_female_user_already_exist_dating_in_this_dating_day');
                }
                return $this;
            }
            $datingMaleUser = new DatingUser($formatParams['datingMaleUser']['user_id']);
            $datingFemaleUser = new DatingUser($formatParams['datingFemaleUser']['user_id']);

            $datingDayModel = $this->datingDayRepository->getById($formatParams['dating']['dating_day_id']);
            $datingPlace = $this->datingPlaceReponsitory->getSpecificDatingPlace($formatParams['dating']['dating_place_id']);
            $this->datingService->createDating($datingMaleUser, $datingFemaleUser, $datingPlace, $datingDayModel, $formatParams['dating']['start_at']);
            $this->message = __('api_messages.successfully_created_new_dating');
            DB::commit();
            return $this;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception(__('api_messages.unable_to_create_dating'));
        }
    }

    /**
     * update dating data
     *
     * @param array $data format [
     * 'maleUserPreferredPlaces' => ['area_id' -> int],
     * 'femaleUserPreferredPlaces' => ['area_id' => int],
     * 'dating_day_id' => int,
     * 'time' => string, 'dating_place_id' => int,
     * 'male' => int, 'female' => int]
     * @param int $id
     * @return $this
     */
    public function updateDating(array $data, $id): AdminDatingServiceInterface
    {
        $formatData = $this->getFormattedDataForDating($data);
        DB::beginTransaction();
        try {
            $maleUser = $this->userRepository->getById($formatData['datingMaleUser']['user_id']);
            $femaleUser = $this->userRepository->getById($formatData['datingFemaleUser']['user_id']);
            $datingModel = $this->datingRepository->getDatingById($id, null, [DatingUserProperty::User]);
            $datingDay = $this->datingDayRepository->getById($formatData['dating']['dating_day_id']);
            $maleValidate = $this->datingService->isDuplicatedOnSameDatingDay($maleUser, $datingDay->getId(), $datingModel);
            $femaleValidate = $this->datingService->isDuplicatedOnSameDatingDay($femaleUser, $datingDay->getId(), $datingModel);
            if (!$maleValidate || !$femaleValidate) {
                $this->status = 512;
                if (!$maleValidate) {
                    $this->message = __('api_messages.dating_male_user_already_exist_dating_in_this_dating_day');
                }
                if (!$femaleValidate) {
                    $this->message = __('api_messages.dating_female_user_already_exist_dating_in_this_dating_day');
                }
                if (!$maleValidate && !$femaleValidate) {
                    $this->message = __('api_messages.dating_male_and_female_user_already_exist_dating_in_this_dating_day');
                }
                return $this;
            }
            $datingPlace = $this->datingPlaceReponsitory->getSpecificDatingPlace($formatData['dating']['dating_place_id']);
            $this->datingService->updateDating($datingModel, $maleUser, $femaleUser, $datingPlace, $datingDay, $formatData['dating']['start_at']);
            $this->message = __('api_messages.successfully_update_dating');
            DB::commit();
            return $this;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception(__('api_messages.unable_to_update_dating'));
        }
    }

    /**
     * Get dating data by id
     *
     * @param int|null $id
     * @return $this
     */
    public function getDatingById($id = null): AdminDatingServiceInterface
    {
        $date = $this->datingRepository->getDatingById($id);
        $datingPlace = $this->datingPlaceReponsitory->getSpecificDatingPlace($date->getDatingPlaceId());
        $item = [];
        $item['male'] = $date->getDatingUsers()->first()->getUserId();
        $item['female'] = $date->getDatingUsers()->last()->getUserId();
        $item['area'] = $datingPlace->getAreaId();
        $item['cafe'] = $date->getDatingPlaceId();
        $item['dateSelected'] = $date->getDatingDay()->getId();
        $item['date'] = $date->getDatingDay()->getDatingDate();
        $item['time'] = $date->getStartAt();
        $this->data = $item;
        return $this;
    }

    /**
     * Cancel dating admin
     *
     * @param int $datingId
     * @param int $userId
     * @return $this
     */
    public function cancelDatingByAdmin(int $datingId, int $userId)
    {
        DB::beginTransaction();

        $user = $this->userRepository->getById($userId);

        if ($this->datingService->cancelDating($user, $datingId)) {
            $this->message = __('api_messages.successfully_cancel_dating');
            DB::commit();
            return $this;
        }
        DB::rollBack();
        throw new \Exception(__('api_messages.unable_to_cancel_dating'));
    }

    // Admin Participation setting - Open/closed/Expired

    /**
     * get participation open/expiry setting data
     *
     * @param array $filter is array have list param like user_gender or some other key for filter data
     *
     * @return $this
     */
    public function getDatingDayOfWeekSetting(array $filter): AdminDatingServiceInterface
    {
        $result = [];
        $participationSettingData = $this->participationOpenExpirySettingRepository->getRange($filter);
        foreach ($participationSettingData as $data) {
            if ($data->getDatingDayOfWeek() === DatingDayOfWeek::Wednesday) {
                if ($data->getIsUser2ndFormCompleted() == 1) {
                    $result['wednesdaySecondFormCompletedOpenDay'] = $data->getOpenDaysBeforeDatingDate();
                    $result['wednesdaySecondFormCompletedExpireDay'] = $data->getExpiryDaysBeforeDatingDate();
                } else {
                    $result['wednesdaySecondFormInCompletedOpenDay'] = $data->getOpenDaysBeforeDatingDate();
                    $result['wednesdaySecondFormInCompletedExpireDay'] = $data->getExpiryDaysBeforeDatingDate();
                }
            }
            if ($data->getDatingDayOfWeek() === DatingDayOfWeek::Saturday) {
                if ($data->getIsUser2ndFormCompleted() == 1) {
                    $result['saturdaySecondFormCompletedOpenDay'] = $data->getOpenDaysBeforeDatingDate();
                    $result['saturdaySecondFormCompletedExpireDay'] = $data->getExpiryDaysBeforeDatingDate();
                } else {
                    $result['saturdaySecondFormInCompletedOpenDay'] = $data->getOpenDaysBeforeDatingDate();
                    $result['saturdaySecondFormInCompletedExpireDay'] = $data->getExpiryDaysBeforeDatingDate();
                }
            }
            if ($data->getDatingDayOfWeek() === DatingDayOfWeek::Sunday) {
                if ($data->getIsUser2ndFormCompleted() == 1) {
                    $result['sundaySecondFormCompletedOpenDay'] = $data->getOpenDaysBeforeDatingDate();
                    $result['sundaySecondFormCompletedExpireDay'] = $data->getExpiryDaysBeforeDatingDate();
                } else {
                    $result['sundaySecondFormInCompletedOpenDay'] = $data->getOpenDaysBeforeDatingDate();
                    $result['sundaySecondFormInCompletedExpireDay'] = $data->getExpiryDaysBeforeDatingDate();
                }
            }
        }
        $this->data = $result;
        return $this;
    }

    /**
     * create or update participation open closed expired setting data
     *
     ** @param array $params
     * @return AdminDatingServiceInterface
     */
    public function createOrUpdateDatingDayOfWeekSetting(array $params): AdminDatingServiceInterface
    {
        $paramsFormat = $this->getConvertMigrateDatingDayOfWeekData($params);
        DB::beginTransaction();
        try {
            foreach ($paramsFormat as $day) {
                foreach ($day as $secondFormCompletedOrNot) {
                    $model = $this->participationOpenExpirySettingRepository
                        ->getDetail(
                            $secondFormCompletedOrNot['user_gender'],
                            $secondFormCompletedOrNot['dating_day_of_week'],
                            $secondFormCompletedOrNot['is_user_2nd_form_completed']
                        );
                    if ($model !== null) {
                        $model->setDatingDayOfWeek($secondFormCompletedOrNot['dating_day_of_week']);
                        $model->setUserGender($secondFormCompletedOrNot['user_gender']);
                        $model->setIsUser2ndFormCompleted($secondFormCompletedOrNot['is_user_2nd_form_completed']);
                        $model->setOpenDaysBeforeDatingDate($secondFormCompletedOrNot['open_days_before_dating_date']);
                        $model->setExpiryDaysBeforeDatingDate($secondFormCompletedOrNot['expiry_days_before_dating_date']);
                    } else {
                        $model = new ParticipationOpenExpirySetting(
                            $secondFormCompletedOrNot['dating_day_of_week'],
                            $secondFormCompletedOrNot['is_user_2nd_form_completed'],
                            $secondFormCompletedOrNot['user_gender'],
                            $secondFormCompletedOrNot['open_days_before_dating_date'],
                            $secondFormCompletedOrNot['expiry_days_before_dating_date']
                        );
                    }
                    $this->participationOpenExpirySettingRepository->save($model);
                }
            }
            DB::commit();
            $this->message = __('api_messages.store_or_update_participation_open_expire_setting_successful');
            return $this;
        } catch (Exception $exception) {
            DB::rollBack();
            $this->message = __('api_messages.store_or_update_participation_open_expire_setting_fail');
            return $this;
        }
    }
    // end Admin Participation setting - Open/closed/Expired

    /**
     * Get dating days
     *
     * @return AdminDatingServiceInterface
     */
    public function getDatingDay(): AdminDatingServiceInterface
    {
        $fromDate = Carbon::now()->toDateString();
        $toDate = Carbon::now()->addWeeks(2)->endOfWeek()->toDateString();
        $datas = $this->datingDayRepository->getRange($fromDate, $toDate);
        $result = [];
        foreach ($datas as $data) {
            $result[] = [
                'id' => $data->getId(),
                'dating_date' => $data->getDatingDate()
            ];
        }
        $this->data = $result;
        return $this;
    }
    /**
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

    /**
     * @param string $date
     * @return DatingDay
     */
    public function getDatingByDate(string $date): DatingDay
    {
        return $this->datingDayRepository->getByDate($date);
    }
}
