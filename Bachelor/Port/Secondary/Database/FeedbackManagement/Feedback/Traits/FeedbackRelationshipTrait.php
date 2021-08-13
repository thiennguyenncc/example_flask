<?php


namespace Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\Traits;


use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\Dating;
use Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\ModelDao\DatingReportGenerateFeedback;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao\FeedbackUserReview;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait FeedbackRelationshipTrait
{
    public function feedbackBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'feedback_by');
    }

    public function feedbackFor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'feedback_for');
    }

    public function dating(): BelongsTo
    {
        return $this->belongsTo(Dating::class);
    }

    public function feedbackUserReview(): HasOne
    {
        return $this->hasOne(FeedbackUserReview::class, 'feedback_id');
    }

    public function datingReportGenerateFeedbacks(): HasMany
    {
        return $this->hasMany(DatingReportGenerateFeedback::class);
    }
}
