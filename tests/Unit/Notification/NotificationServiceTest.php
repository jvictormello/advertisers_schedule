<?php

namespace Tests\Unit\Notification;

use App\Models\Advertiser;
use App\Models\Contractor;
use App\Services\Authentication\AuthenticationServiceContract;
use App\Services\Notification\NotificationServiceContract;
use Database\Seeders\DatabaseSeeder;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    private $notificationService;
    private $authenticationService;
    private $advertiser;
    private $contractor;
    private $testPassword;

    public function setUp(): void
    {
        parent::setUp();
        $this->notificationService = app()->make(NotificationServiceContract::class);
        $this->authenticationService = app()->make(AuthenticationServiceContract::class);
        $this->seed(DatabaseSeeder::class);
        $this->advertiser = Advertiser::first();
        $this->contractor = Contractor::first();
        $this->testPassword = 'abcd1234';
    }

    /**
     * Test getAllNotifications method with Advertiser info.
     *
     * @return void
     */
    public function test_get_all_notifications_method_with_advertiser_info()
    {
        $credentials = [
            'login' => $this->advertiser->login,
            'password' => $this->testPassword
        ];

        $this->authenticationService->loginAdvertiser($credentials);
        Auth::guard('advertisers')->attempt($credentials);

        $notifications = $this->notificationService->getAllNotifications();

        $advertiserIsTheOwner = true;
        foreach ($notifications as $notification) {
            if ($notification->schedule->advertiser_id != $this->advertiser->id) {
                $advertiserIsTheOwner = false;
            }
        }
        $this->assertTrue($advertiserIsTheOwner);
    }

    /**
     * Test getAllNotifications method with Contractor info
     *
     * @return void
     */
    public function test_get_all_notifications_method_with_contractor_info()
    {
        $credentials = [
            'login' => $this->contractor->login,
            'password' => $this->testPassword
        ];

        $this->authenticationService->loginContractor($credentials);
        Auth::guard('contractors')->attempt($credentials);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->notificationService->getAllNotifications();
    }

    /**
     * Test getAllNotifications method with no logged user.
     *
     * @return void
     */
    public function test_get_all_notifications_method_with_no_logged_user()
    {
        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->notificationService->getAllNotifications();
    }
}
