<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao;

use Bachelor\Domain\UserManagement\User\Models\User as UserDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\User\Traits\HasFactory;
use Bachelor\Port\Secondary\Database\UserManagement\User\Traits\UserRelationshipTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Collection;

class User extends BaseModel
{
    use Notifiable, UserRelationshipTrait, HasFactory, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /*
     * The columns that should be searched.
     *
     * @var array
     */
    public static array $search = ['id', 'name', 'email'];

    /**
     * The relations to eager load on every query.
     * TODO: should change to lazy load because user table is used everywhere. This heavily affect to query performance
     *
     * @var array
     */
    protected $with = [];

    /*
    * Filer that's applicable for the model
    *
    * @var array
    */
    protected array $filter = [
        'status' => [
            // TODO mention all statuses
        ]
    ];

    /**
     * Get the search params
     *
     * @param $search
     * @return array
     */
    public static function getSortedSearch(array $search): array
    {
        // Initialize the search params
        $finalSearchKeys = [
            'id' => [],
            'name' => [],
            'email' => []
        ];
        foreach ($search as $eachSearchKey)

            if (preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $eachSearchKey))
                array_push($finalSearchKeys['email'], $eachSearchKey);
            elseif (preg_match('/([0-9]+)/', $eachSearchKey))
                array_push($finalSearchKeys['id'], (int) $eachSearchKey);
            else
                array_push($finalSearchKeys['name'], $eachSearchKey);

        return $finalSearchKeys;
    }

    public function toDomainEntity(): UserDomainModel
    {
        $user = new UserDomainModel(
            $this->name,
            $this->email,
            $this->gender,
            $this->mobile_number,
            $this->status,
            $this->b_rate,
            $this->registration_steps,
            $this->prefecture_id,
            $this->team_member_rate,
            $this->flex_point,
            (bool) $this->is_fake,
            $this->support_tracking_url,
            $this->lp_query_str,
            $this->userPaymentCustomer()->first() ? $this->userPaymentCustomer()->first()->toDomainEntity() : null,
        );

        $user->setId($this->getKey());

        if ($this->relationLoaded('userPreference')) {
            $user->setUserPreference(optional($this->userPreference()->first())->toDomainEntity());
        }

        if ($this->relationLoaded('userProfile')) {
            $user->setUserProfile(optional($this->userProfile()->first())->toDomainEntity());
        }

        if ($this->relationLoaded('userInfoUpdatedTime')) {
            $user->setUserInfoUpdatedTime(optional($this->userInfoUpdatedTime()->first())->toDomainEntity());
        }

        if ($this->relationLoaded('userImages')) {
            $user->setUserImagesCollection($this->userImages()->get()->transform(function ($userImage) {
                return $userImage->toDomainEntity();
            }));
        }

        if ($this->relationLoaded('userPreferredAreas')) {
            $user->setUserPreferredAreasCollection($this->userPreferredAreas()->get()->transform(function ($userPreferredArea) {
                return $userPreferredArea->toDomainEntity();
            }));
        }

        if ($this->relationLoaded('userInvitation')) {
            $user->setUserInvitation(optional($this->userInvitation()->first())->toDomainEntity());
        }

        if ($this->relationLoaded('prefecture')) {
            $user->setPrefecture(optional($this->prefecture()->first())->toDomainEntity());
        }

        return $user;
    }

    /**
     * @param UserDomainModel $user
     * @return User
     */
    protected function fromDomainEntity($user)
    {
        $this->name = $user->getName();
        $this->email = $user->getEmail();
        $this->gender = $user->getGender();
        $this->mobile_number = $user->getMobileNumber();
        $this->status = $user->getStatus();
        $this->b_rate = $user->getBRate();
        $this->registration_steps = $user->getRegistrationSteps();
        $this->prefecture_id = $user->getPrefectureId();
        $this->support_tracking_url = $user->getSupportTrackingUrl();
        $this->team_member_rate = $user->getTeamMemberRate();
        $this->flex_point = $user->getFlexPoint();
        $this->is_fake = (int) $user->isFake();
        $this->lp_query_str = $user->getLpQueryStr();

        return $this;
    }

    /**
     * Custom activity before storing
     *
     * @param $activity
     * @param $eventName
     * @return void
     */
    public function tapActivity(Activity $activity, string $eventName)
    {
        if (Auth::user()) {
            $activity->causer_type = class_basename(get_class(Auth::user()));
        } elseif (is_null(Auth::user())) {
            $activity->causer_type = "System";
        }
    }

    /**
     * Get activity log options
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        $baseClass = class_basename(get_class($this));
        return LogOptions::defaults()
            ->logFillable()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName("Log changing {$baseClass}")
            ->setDescriptionForEvent(fn (string $eventName) => "This model {$baseClass} has been {$eventName}");
    }
}
