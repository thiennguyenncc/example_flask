<?php

namespace Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\Repository;

use Bachelor\Domain\FeedbackManagement\DatingReport\Interfaces\DatingReportRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\DatingReport\Models\DatingReport as DatingReportDomainModel;
use Bachelor\Domain\FeedbackManagement\DatingReport\Models\DatingReportGenerateFeedback;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\ModelDao\DatingReport;
use Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\ModelDao\DatingReportGenerateFeedback as ModelDaoDatingReportGenerateFeedback;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DatingReportRepository extends EloquentBaseRepository implements DatingReportRepositoryInterface
{
    public function __construct(DatingReport $datingReport)
    {
        parent::__construct($datingReport);
    }

    /**
     * @param $userId
     * @return ?DatingReportDomainModel
     */
    public function getLastDatingReportOfUser($userId): ?DatingReportDomainModel
    {
        $datingReport = $this->model
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->where('display_date', '<=', Carbon::now()->startOfDay())
            ->first();

        return $datingReport?->toDomainEntity();
    }

    /**
     * @param $userId
     * @param $datingReportData
     * @param $reviewCount
     * @param $feedbackIds
     * @param $displayDatingReportTime
     * @throws \Exception
     */
    public function saveDatingReport(DatingReportDomainModel $datingReport): DatingReportDomainModel
    {
        DB::beginTransaction();
        try {
            $datingReport = $this->modelDAO->saveData($datingReport);
            $datingReport->getDatingReportGenerateFeedbacks()->each(
                function (DatingReportGenerateFeedback $drGenerateFeedback) use ($datingReport) {
                    $drGenerateFeedback->setDatingReportId($datingReport->getId());
                    $drGenerateFeedbackDAO = new ModelDaoDatingReportGenerateFeedback();
                    $drGenerateFeedbackDAO->saveData($drGenerateFeedback);
                }
            );
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $datingReport;
    }

    public function getReportsByUserIds(array $userIds): Collection
    {
        $datingReports = $this->createQuery()
            ->whereIn('user_id', $userIds)
            ->orderBy('id', 'DESC')
            ->get();

        return $this->transformCollection($datingReports);
    }

    /**
     * @param array $userIds
     * @return array
     */
    public function getUserIdsReportDisplayDateToday(array $userIds = []): array
    {
        $builder = $this->model->newModelQuery();

        if (count($userIds)) {
            $builder = $builder->whereIn('user_id', $userIds);
        }

        return $builder->where('display_date', now()->format('Y-m-d 00:00:00'))
            ->pluck('user_id')
            ->toArray();
    }

    /**
     * @param array $userIds
     * @return array
     */
    public function getFeedbackNumbersOfDatingReportByUserIds(array $userIds): array
    {
        return $this->model->newModelQuery()
            ->whereIn('user_id', $userIds)
            ->whereNotNull('display_date')
            ->groupBy('user_id')
            ->pluck('feedback_count', 'user_id')
            ->toArray();
    }

    /**
     * @param integer $userId
     * @param integer $datingId
     * @return Collection
     */
    public function getDatingReportsByUserIdNDatingId(int $userId, int $datingId): Collection
    {
        $datingReports = $this->model->newModelQuery()
            ->whereHas('feedbacks', function ($query) use ($datingId) {
                $query->where('dating_id', $datingId);
            })
            ->where('user_id', $userId)
            ->get();

        return $this->transformCollection($datingReports);
    }

}
