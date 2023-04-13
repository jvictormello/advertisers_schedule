<?php

namespace Tests\Feature\Authentication;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    use RefreshDatabase;

    private $advertiser;
    private $contractor;
    private $testPassword;

    public function setUp(): void
    {
        parent::setUp();
        $this->testPassword = 'abcd1234';
        $this->advertiser = $this->createAdvertisers();
        $this->contractor = $this->createContractors();
    }

    /**
     * Test authenticate as an Advertiser.
     *
     * @return void
     */
    public function test_authenticate_as_an_advertiser()
    {
        $postBody = [
            'login' => $this->advertiser->login,
            'password' => $this->testPassword
        ];

        $response = $this->post('api/login/advertiser', $postBody)->assertStatus(Response::HTTP_OK);

        $this->assertNotNull($response->getData()->access_token);
    }

    /**
     * Test authenticate as a Contractor.
     *
     * @return void
     */
    public function test_authenticate_as_a_contractor()
    {
        $postBody = [
            'login' => $this->contractor->login,
            'password' => $this->testPassword
        ];

        $response = $this->post('api/login/contractor', $postBody)->assertStatus(Response::HTTP_OK);

        $this->assertNotNull($response->getData()->access_token);
    }

    /**
     * Test a Contractor tries to authenticate as an Advertiser.
     *
     * @return void
     */
    public function test_a_contractor_tries_to_authenticate_as_an_advertiser()
    {
        $postBody = [
            'login' => $this->contractor->login,
            'password' => $this->testPassword
        ];

        $response = $this->post('api/login/advertiser', $postBody)->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertEquals('Unauthorized', $response->getData()->message);
    }

    /**
     * Test an Advertiser tries to authenticate as a Contractor.
     *
     * @return void
     */
    public function test_an_advertiser_tries_to_authenticate_as_a_contractor()
    {
        $postBody = [
            'login' => $this->advertiser->login,
            'password' => $this->testPassword
        ];

        $response = $this->post('api/login/contractor', $postBody)->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertEquals('Unauthorized', $response->getData()->message);
    }
}
