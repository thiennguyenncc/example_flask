<?php

namespace Bachelor\Application\Admin\Services\Interfaces;


use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;

interface AdminDatingServiceInterface
{
    /**
     * 12pm, 3pm rematching from csv file
     *
     * @param string $filePath
     * @return AdminDatingServiceInterface
     */
    public function rematchFromFile($filePath): AdminDatingServiceInterface;

    // Admin Participation setting - Open/closed/Expired

    /**
     * get matching date info with matching date setting data
     *
     * @param array $params
     * @return AdminDatingServiceInterface
     */
    public function getDatingDayOfWeekSetting(array $params): AdminDatingServiceInterface;

    /**
     * create or update participation open closed expired setting data
     *
     ** @param array $params
     * @return AdminDatingServiceInterface
     */
    public function createOrUpdateDatingDayOfWeekSetting(array $params): AdminDatingServiceInterface;

    // end Admin Participation setting - Open/closed/Expired

    //matched user pair list
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
    public function getDatingHistory(?int $weekOffset = 4, ?int $status = null, ?string $search = "", ?int $isFake = null, ?string $datingDate = null, ?string $startTime = null): AdminDatingServiceInterface;

    /**
     * Get dating data by id
     *
     * @param int|null $id
     * @return AdminDatingServiceInterface
     */
    public function getDatingById($id = null): AdminDatingServiceInterface;

    /**
     * Cancel dating in match user pair list admin
     *
     * @param int $datingId
     * @param int $userId
     * @return bool
     */
    public function cancelDatingByAdmin(int $datingId, int $userId);

    /**
     * @return array
     */
    public function handleApiResponse(): array;

    /**
     * Get dating data by date
     * @param string $date
     * @return DatingDay
     */
    public function getDatingByDate(string $date): DatingDay;
}
