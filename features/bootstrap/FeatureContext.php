<?php

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use features\Http\Traits\UtilityTrait;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends TestCase implements Context
{
    use UtilityTrait;

    const API_ROUTE = 'api/v2/';

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
     * @throws Exception
     */
    public function before()
    {
        DB::beginTransaction();
    }

    /** @AfterScenario
     */
    public function after()
    {
        DB::rollBack();
        parent::tearDown();
    }

    /**
     * @Given /^Our application is online to receive requests$/
     */
    public function ourApplicationIsOnlineToReceiveRequests ()
    {
        $this->assertFalse(file_exists(dirname(__FILE__) . "/../storage/framework/down"));
    }

    /**
     * @When /^webapp make a \'([^\']*)\' request to "([^"]*)" with no payload$/
     * @param $method
     * @param $route
     */
    public function webappMakeARequestToWithNoPayload ( $method , $route )
    {
        $this->response = $this->{$method}($route);
    }

    /**
     * @Then /^it should get a response of (\d+)$/
     * @param $code
     */
    public function itShouldGetAResponseOf ( $code )
    {
        $this->assertEquals($code, $this->response->getStatusCode());
    }

    /**
     * @When /^webapp make a \'([^\']*)\' request to an api route "([^"]*)" with no payload$/
     * @param $method
     * @param $route
     */
    public function webappMakeARequestToAnApiRouteWithNoPayload (string $method , string $route )
    {
        $this->response = $this->{$method}('/'.self::API_ROUTE.$route);
    }

    /**
     * @When /^there is an api route "([^"]*)" exists in our application$/
     * @param $route
     */
    public function thereIsAnApiRouteExistsInOurApplication ( string $route )
    {
        $this->assertTrue(self::checkIfRouteExists(self::getAllRoutes(), self::API_ROUTE.$route));
    }

    /**
     * @Then /^there should be an controller \'([^\']*)\' exists to serve the request with \'([^\']*)\' function$/
     * @param $file
     * @param $function
     */
    public function thereShouldBeAnControllerExistsToServeTheRequestWithFunction (string $file , string $function )
    {
       self::checkIfRequestHandlerExists($file, $function);
    }

    /**
     * @When /^webapp make a request to "([^"]*)" route with payload:$/
     * @param $route
     * @param TableNode $payload
     */
    public function webappMakeARequestToRouteWithPayload ( $route , TableNode $payload )
    {
        $this->response = $this->post(self::API_ROUTE.$route, self::getPayload($payload->getHash()));
    }

    /**
     * @When /^webapp make a request to "([^"]*)" route without param$/
     * @param $route
     */
    public function webappMakeARequestToRouteWithoutParam ( $route )
    {
        $this->response = $this->post(self::API_ROUTE.$route, []);
    }

    /**
     * @When /^verification code was sent to \'([^\']*)\'$/
     * @param $mobileNumber
     */
    public function verificationCodeWasSentTo ( $mobileNumber )
    {
        Cache::remember($mobileNumber, 5, function () {
            return 1111;
        });
    }

}
