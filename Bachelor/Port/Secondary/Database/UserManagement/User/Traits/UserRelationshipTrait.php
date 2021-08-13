<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\User\Traits;

use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\Dating;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUser;
use Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\ModelDao\DatingReport;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantForRematch\ModelDao\ParticipantForRematch;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\ModelDao\Coupon;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentCard\ModelDao\PaymentCard;
use Bachelor\Port\Secondary\Database\PaymentManagement\Plan\ModelDao\UserPlan;
use Bachelor\Port\Secondary\Database\PaymentManagement\Subscription\ModelDao\Subscription;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\ModelDao\UserPaymentCustomer;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\ModelDao\UserTrial;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserLogin;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAnalytic;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao\UserCoupon;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao\UserCouponHistory;
use Bachelor\Port\Secondary\Database\UserManagement\UserInvitation\ModelDao\UserInvitation;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreferredArea\ModelDao\UserPreferredArea;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserImage;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserProfile;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreference\ModelDao\UserPreference;
use Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\ModelDao\UserInfoUpdatedTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait UserRelationshipTrait
{
    /**
     * Get user auth related data
     *
     * @return HasOne
     */
    public function userAuth()
    {
        return $this->hasOne(UserAuth::class);
    }

    /**
     * Get user login related data
     *
     * @return HasOne
     */
    public function userLogin()
    {
        return $this->hasOne(UserLogin::class);
    }

    /**
     * Get user profile related data
     *
     * @return HasOne
     */
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get user preference related data
     *
     * @return HasOne
     */
    public function userPreference()
    {
        return $this->hasOne(UserPreference::class);
    }

    /**
     * Get user login related data
     *
     * @return HasMany
     */
    public function userPreferredAreas()
    {
        return $this->hasMany(UserPreferredArea::class);
    }

    /**
     * Get user dating related data
     *
     * @return HasMany
     */
    public function dating()
    {
        return $this->hasMany(Dating::class);
    }

    /**
     * Get user dating details related data
     *
     * @return HasMany
     */
    public function datingUsers()
    {
        return $this->hasMany(DatingUser::class, 'user_id');
    }

    /**
     * Get user analytics related data
     *
     * @return HasMany
     */
    public function userAnalytics()
    {
        return $this->hasMany(UserAnalytic::class);
    }

    /**
     * Provides the data of the prefecture to which user belongs to
     *
     * @return BelongsTo
     */
    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    /**
     * Get all user cards
     *
     * @return HasMany
     */
    public function paymentCards()
    {
        return $this->hasMany(PaymentCard::class);
    }

    /**
     * Get all user payment providers
     *
     * @return HasMany
     */
    public function userPaymentCustomer()
    {
        return $this->hasOne(UserPaymentCustomer::class);
    }

    /**
     * Get all user subscriptions
     *
     * @return HasMany
     */
    public function subscriptions()
    {
        return $this->hasManyThrough(Subscription::class, UserPaymentCustomer::class);
    }

    /**
     * Get all user trial data
     *
     * @return HasOne
     */
    public function userTrial()
    {
        return $this->hasOne(UserTrial::class);
    }

    /**
     * retrieve plan of the user
     *
     * @return HasOne
     */
    public function userPlan()
    {
        return $this->hasOne(UserPlan::class);
    }

    /**
     * Coupon Information
     *
     * @return BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get user coupon
     *
     * @return HasMany
     */
    public function userCoupon()
    {
        return $this->hasMany(UserCoupon::class);
    }

    /**
     * User coupon histories
     *
     * @return HasMany
     */
    public function userCouponHistories()
    {
        return $this->hasMany(UserCouponHistory::class);
    }

    /**
     * Get all the user images
     *
     * @return mixed
     */
    public function userImages()
    {
        return $this->hasMany(UserImage::class);
    }

    /**
     * @return HasMany
     */
    public function datingReports(): HasMany
    {
        return $this->hasMany(DatingReport::class);
    }

    /**
     * Get user info updated time related data
     *
     * @return HasOne
     */
    public function userInfoUpdatedTime()
    {
        return $this->hasOne(UserInfoUpdatedTime::class);
    }

    /**
     * Get user invitation related data
     *
     * @return HasOne
     */
    public function userInvitation()
    {
        return $this->hasOne(UserInvitation::class);
    }

    /**
     * @return HasMany
     */
    public function participantMainMatches(): HasMany
    {
        return $this->hasMany(ParticipantMainMatch::class);
    }

    /**
     * @return HasMany
     */
    public function participantForRematches(): HasMany
    {
        return $this->hasMany(ParticipantForRematch::class);
    }
}
