<?php

namespace Bachelor\Domain\UserManagement\User\Interfaces;

use Bachelor\Domain\Base\Filter;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\User\Models\User as UserDomainModel;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     * @param array|null $relations
     * @return User|null
     */
    public function getById(int $id, ?array $relations = []): ?User;

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User;

    /**
     * @param array $ids
     * @param string|null $gender
     * @param int|null $userStatus
     * @param array|null $relations
     * @return Collection
     */
    public function getByIds(array $ids, string $gender = null, int $userStatus = null, ?array $relations = []): Collection;

    /**
     * @param Filter $filter
     * @return Collection | User[]
     */
    public function getList(Filter $filter): Collection;

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user): User;

    /**
     * Retrieve users by keyword filter
     *
     * @param string $keyword
     * @return array
     */
    public function retrieveUserList(?string $search = "", int $gender = null, int $status = null, int $isFake = null, int $perPage = 50): array;

    /**
     * Get fake female users
     *
     * @return Collection
     */
    public function retrieveFakeFemaleUsers(): Collection;

    /**
     * @param $limit
     * @return Collection
     */
    public function getUsersByLimit($limit): Collection;

    /**
     * @param array $params
     * @return UserDomainModel|null
     */
    public function getUserPreferredAreaData(array $params): ?UserDomainModel;

    /**
     * @param int $id
     * @return UserDomainModel|null
     */
    public function getAllUserDataById(int $id): ?UserDomainModel;

    /**
     * @return User|null
     */
    public function getRandomUser(): ?User;

    /**
     * @return Collection
     */
    public function getAllNotInStatusByUserIds(array $userIds, array $statuses): Collection;
}
