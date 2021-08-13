<?php


namespace Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\Traits;


use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao\Feedback;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait FeedbackUserReviewRelationshipTrait
{
    public function feedback(): BelongsTo
    {
        return $this->belongsTo(Feedback::class);
    }
}
