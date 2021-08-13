<?php

namespace Authentication;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use features\Http\Traits\UtilityTrait;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class AuthenticationContext extends TestCase implements Context
{
    use UtilityTrait;

    const API_ROUTE = '/api/v2/';

    /*
    *  Store all the responses
    */
    public $response = [];

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
        parent::setUp();
    }

    /** @BeforeScenario
     * @param BeforeScenarioScope $scope
     * @throws \Exception
     */
    public function before(BeforeScenarioScope $scope)
    {
        DB::beginTransaction();
    }

    /** @AfterScenario
     * @param AfterScenarioScope $scope
     */
    public function after(AfterScenarioScope $scope)
    {
        DB::rollBack();
        parent::tearDown();
    }
}
