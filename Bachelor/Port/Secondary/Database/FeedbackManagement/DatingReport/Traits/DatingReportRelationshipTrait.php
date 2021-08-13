<?php

namespace Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\Traits;

use Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\ModelDao\DatingReportGenerateFeedback;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao\Feedback;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait DatingReportRelationshipTrait
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function feedbacks(): BelongsToMany
    {
        return $this->belongsToMany(Feedback::class, 'dating_report_generate_feedback');
    }

    public function datingReportGenerateFeedback(): HasMany
    {
        return $this->hasMany(DatingReportGenerateFeedback::class);
    }
}
