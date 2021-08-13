<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\Trait;

use Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\Factory\UserTrialFactory;

trait HasFactory
{
    /**
     * Get a new factory instance for the model.
     *
     * @param  mixed  $parameters
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function factory(...$parameters)
    {
        return new UserTrialFactory();
    }
}
