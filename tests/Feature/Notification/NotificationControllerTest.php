<?php

namespace Tests\Feature\Notification;

use App\Models\Advertiser;
use App\Models\Contractor;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    private $advertiser;
    private $contractor;
    private $testPassword;
    private $fakeJwtToken;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->advertiser = Advertiser::first();
        $this->contractor = Contractor::first();
        $this->testPassword = 'abcd1234';
        $this->fakeJwtToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.
        eyJpc3MiOiJodHRwOlwvXC9mbS1jYXRlOjgwODBcL2FwaVwvbG9naW5cL2FkdmVydGlz
        ZXIiLCJpYXQiOjE2ODEzMjYyMTMsImV4cCI6MTY4MTM0NzgxMywibmJmIjoxNjgxMzI2
        MjEzLCJqdGkiOiJNY1hMeFVRSlMxdlRIWWxLIiwic3ViIjoxLCJwcnYiOiI0YTg0OGZi
        MDJmNjNjZGNiOWMyZDdhMjcxOWVhMzUzNDUyNzZkMzhiIn0.K0rJwGtrCDjAXkxGJ-uT
        afOZi5omemFAZ9WRtU_ydDw';
    }

    /**
     * Test logged advertiser tries to get the notifications.
     *
     * @return void
     */
    public function test_advertiser_tries_to_get_the_notifications()
    {
        $jwtToken = 'Bearer '.$this->be($this->advertiser, 'advertisers')->fakeJwtToken;

        $response = $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->get('api/notifications')->assertStatus(Response::HTTP_OK);

        $advertiserIsTheOwner = true;
        foreach ($response->getData() as $notification) {
            if ($notification->schedule->advertiser_id != $this->advertiser->id) {
                $advertiserIsTheOwner = false;
            }
        }

        $this->assertTrue($advertiserIsTheOwner);
    }

    /**
     * Test logged contractor tries to get the notifications.
     *
     * @return void
     */
    public function test_contractor_tries_to_get_the_notifications()
    {
        $jwtToken = 'Bearer '.$this->be($this->contractor, 'contractors')->fakeJwtToken;

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->get('api/notifications')->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test not logged user tries to get notifications.
     *
     * @return void
     */
    public function test_not_logged_user_tries_to_get_notifications()
    {
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->get('api/schedules')->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test get notifications using a fake JWT Token.
     *
     * @return void
     */
    public function test_get_notifications_using_a_fake_jwt_token()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->fakeJwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->get('api/schedules')->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
