<?php

namespace UnitContexts;

use FeatureContext;
use Behat\Behat\Context\Context;

class BaseContext extends FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        parent::__construct();
    }

}
