<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\User\Repository;

use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\User\Models\User as UserDomainModel;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User as UserDao;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\ModelDao\UserInfoUpdatedTime;
use Bachelor\Utility\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @TODO: implement UserRepositoryInterface instead
 */
class UserRepository extends EloquentBaseRepository implements UserRepositoryInterface
{
    private UserInfoUpdatedTime $userInfoUpdatedTime;

    /**
     * EloquentUserRepository constructor.
     * @param UserDao $model
     * @param UserInfoUpdatedTime $userInfoUpdatedTime
     */
    public function __construct(UserDao $model, UserInfoUpdatedTime $userInfoUpdatedTime)
    {
        $this->userInfoUpdatedTime = $userInfoUpdatedTime;
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array|null $relations
     * @return UserDomainModel|null
     */
    public function getById(int $id, ?array $relations = []): ?UserDomainModel
    {
        $query = $this->createQuery()->where('id', $id);
        if (!empty($relations)) {
            $query = $query->with($relations);
        }
        $modelDao = $query->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param string $email
     * @return UserDomainModel|null
     */
    public function getUserByEmail(string $email): ?UserDomainModel
    {
        return optional($this->createQuery()->where('email', $email)->first())->toDomainEntity();
    }

    /**
     * @param UserDomainModel $user
     * @return UserDomainModel
     * @throws \Exception
     */
    public function save(UserDomainModel $user): UserDomainModel
    {
        $userModelDao = $this->createModelDAO($user->getId());
        if ($user->getUserInfoUpdatedTime()) {
            $this->userInfoUpdatedTime->saveData($user->getUserInfoUpdatedTime());
        }

        return $userModelDao->saveData($user);
    }

    /**
     * retirieve users collection
     *
     * @param string $search
     * @param integer $gender
     * @param integer $status
     * @param integer $isFake
     * @param integer $perPage
     * @return array
     */
    public function retrieveUserList(?string $search = "", int $gender = null, int $status = null, int $isFake = null, int $perPage = 50): array
    {
        $query = $this->createQuery()
            ->select(['users.*', 'auth_id', 'auth_type'])
            ->join('user_auth', 'users.id', '=', 'user_auth.user_id');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                return $query->where('users.id', $search)
                    ->orWhere('email', $search)
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('mobile_number', 'like', $search);
            });
        }

        if ($gender) $query->where('gender', $gender);
        if ($status) $query->where('status', $status);
        if ($isFake) $query->where('is_fake', $isFake);

        if ($perPage == 0) {
            return ["data" => $query->get()->toArray()];
        } else {
            return $query->paginate($perPage)->toArray();
        }
    }

    public function retrieveUsers()
    {
        return $this->model->buildIndexQuery();
    }

    /**
     * Get the user preferred data
     *
     * @param array $params
     * @return UserDomainModel|null
     */
    public function getUserPreferredAreaData(array $params): ?UserDomainModel
    {
        $modelDao = $this->createQuery()->with(['userPreferredAreas'])->where('id', $params['id'])->first();
        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * Get all user data by id
     *
     * @param int $id
     * @return ?UserDomainModel
     */
    public function getAllUserDataById(int $id): ?UserDomainModel
    {
        $query = $this->model->with([
            'userProfile',
            'userPreference',
            'userPreferredAreas',
            'prefecture',
            'userImages'
        ])->where('id', $id);

        $modelDao = $query->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param array $ids
     * @param string|null $gender
     * @param int|null $userStatus
     * @param array|null $relations
     * @return Collection
     */
    public function getByIds(array $ids, string $gender = null, int $userStatus = null, ?array $relations = []): Collection
    {
        $query = $this->createQuery()
            ->whereIn('id', $ids);
        if ($gender) {
            $query = $query->where('gender', $gender);
        }
        if ($userStatus) {
            $query = $query->where('status', $userStatus);
        }
        if (!empty($relations)) {
            $query = $query->with($relations);
        }

        return $this->transformCollection($query->get());
    }

    /**
     * Get fake female users
     *
     * @return Collection
     */
    public function retrieveFakeFemaleUsers(): Collection
    {
        $builder = $this->model->buildIndexQuery(['filter' => [
            'status' => UserStatus::ApprovedUser,
            'is_fake' => Status::Active,
            'gender' => UserGender::Female
        ]]);

        return $this->transformCollection($builder->get());
    }

    /**
     * @param $limit
     * @return Collection
     */
    public function getUsersByLimit($limit): Collection
    {
        $query = $this->createQuery()
            ->orderBy('id', 'DESC')
            ->limit($limit);

        return $this->transformCollection($query->get());
    }

    /**
     * @return UserDomainModel|null
     */
    public function getRandomUser(): ?User
    {
        $user = $this->createQuery()->inRandomOrder()->first();

        return $user ? $user->toDomainEntity() : null;
    }

    /**
     * @return Collection
     */
    public function getAllNotInStatusByUserIds(array $userIds, array $statuses): Collection
    {
        $query = $this->createQuery()
            ->whereIn('id', $userIds)
            ->whereNotIn('status', $statuses);

        return $this->transformCollection($query->get());
    }
}
