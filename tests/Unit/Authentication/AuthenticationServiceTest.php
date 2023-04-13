<?php

namespace Tests\Unit\Authentication;

use App\Services\Authentication\AuthenticationServiceContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthenticationServiceTest extends TestCase
{
    use RefreshDatabase;

    private $authenticationService;
    private $advertiser;
    private $contractor;
    private $testPassword;

    public function setUp(): void
    {
        parent::setUp();
        $this->authenticationService = app()->make(AuthenticationServiceContract::class);
        $this->testPassword = 'abcd1234';
        $this->advertiser = $this->createAdvertisers();
        $this->contractor = $this->createContractors();
    }

    /**
     * Test loginAdversiter method with Advertiser info.
     *
     * @return void
     */
    public function test_login_advertiser_method_with_advertiser_info()
    {
        $credentials = [
            'login' => $this->advertiser->login,
            'password' => $this->testPassword
        ];

        $response = $this->authenticationService->loginAdvertiser($credentials);

        $this->assertNotNull($response['access_token']);
    }

    /**
     * Test loginContractor method with Contractor info.
     *
     * @return void
     */
    public function test_login_contractor_method_with_contractor_info()
    {
        $credentials = [
            'login' => $this->contractor->login,
            'password' => $this->testPassword
        ];

        $response = $this->authenticationService->loginContractor($credentials);

        $this->assertNotNull($response['access_token']);
    }

    /**
     * Test loginAdversiter method with Contractor info.
     *
     * @return void
     */
    public function test_login_advertiser_method_with_contractor_info()
    {
        $credentials = [
            'login' => $this->contractor->login,
            'password' => $this->testPassword
        ];

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Not authorized');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->authenticationService->loginAdvertiser($credentials);
    }

    /**
     * Test loginAdversiter method with Contractor info.
     *
     * @return void
     */
    public function test_login_contractor_method_with_advertiser_info()
    {
        $credentials = [
            'login' => $this->advertiser->login,
            'password' => $this->testPassword
        ];

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Not authorized');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->authenticationService->loginContractor($credentials);
    }
}
