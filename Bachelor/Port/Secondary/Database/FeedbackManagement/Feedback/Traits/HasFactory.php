<?php


namespace Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\Traits;


use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\Factory\FeedbackFactory;

trait HasFactory
{
    /**
     * Get a new factory instance for the model.
     *
     * @param mixed $parameters
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function factory(...$parameters)
    {
        return new FeedbackFactory();
    }
}
