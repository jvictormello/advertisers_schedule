<?php

namespace Tests\Unit\Notification;

use App\Models\Advertiser;
use App\Models\Contractor;
use App\Services\Notification\NotificationServiceContract;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    private $notificationService;
    private $advertiser;
    private $contractor;

    public function setUp(): void
    {
        parent::setUp();
        $this->notificationService = app()->make(NotificationServiceContract::class);
        $this->seed(DatabaseSeeder::class);
        $this->advertiser = Advertiser::first();
        $this->contractor = Contractor::first();
    }

    /**
     * Test getAllNotifications method with Advertiser info.
     *
     * @return void
     */
    public function test_get_all_notifications_method_with_advertiser_info()
    {
        $this->be($this->advertiser, 'advertisers');

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
        $this->be($this->contractor, 'contractors');

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
