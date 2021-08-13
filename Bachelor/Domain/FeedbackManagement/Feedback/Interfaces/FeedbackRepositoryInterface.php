<?php

namespace Bachelor\Domain\FeedbackManagement\Feedback\Interfaces;

use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\FeedbackManagement\Feedback\Models\Feedback;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Support\Collection;


interface FeedbackRepositoryInterface
{
    /**
     * Handle store feedback
     *
     * @param Feedback $feedback
     * @return bool
     */
    public function handleStoreFeedback(Feedback $feedback): bool;

    /**
     * @param integer $userId
     * @param integer|null $calculateableReport
     * @param integer|null $limit
     * @param array|null $with
     * @return Collection
     */
    public function getLatestFeedbacksFor(int $userId, ?int $calculateableReport = null, ?int $limit = null, ?array $with = null): Collection;

    /**
     * @param array $userIds
     * @param array|null $with
     * @return Collection
     */
    public function getLateFeedbacksForUserIds(array $userIds, ?int $calculateableReport = null, ?array $with = null) : Collection;

    /**
     * @param $userId
     * @return ?Feedback
     */
    public function getLastFeedbackOfUser($userId): ?Feedback;
}
