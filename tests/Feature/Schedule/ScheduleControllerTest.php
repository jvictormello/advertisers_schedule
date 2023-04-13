<?php

namespace Tests\Feature\Schedule;

use App\Models\Advertiser;
use App\Models\Contractor;
use App\Models\Schedule;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
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
     * Test logged advertiser tries to get all advertiser's schedules.
     *
     * @return void
     */
    public function test_advertiser_tries_to_get_all_the_schedules()
    {
        $authBody = [
            'login' => $this->advertiser->login,
            'password' => $this->testPassword
        ];
        $authResponse = $this->post('api/login/advertiser', $authBody)->assertStatus(Response::HTTP_OK);
        $jwtToken = 'Bearer '.$authResponse->getData()->access_token;

        $response = $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->get('api/schedules')->assertStatus(Response::HTTP_OK);

        $advertiserIsTheOwner = true;
        foreach ($response->getData() as $schedule) {
            if ($schedule->advertiser_id != $this->advertiser->id) {
                $advertiserIsTheOwner = false;
            }
        }

        $this->assertTrue($advertiserIsTheOwner);
    }

    /**
     * Test logged contractor tries to get all by another advertiser.
     *
     * @return void
     */
    public function test_contractor_tries_to_get_all_the_schedules()
    {
        $authBody = [
            'login' => $this->contractor->login,
            'password' => $this->testPassword
        ];
        $authResponse = $this->post('api/login/contractor', $authBody)->assertStatus(Response::HTTP_OK);
        $jwtToken = 'Bearer '.$authResponse->getData()->access_token;

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->get('api/schedules')->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test get all schedules not being logged.
     *
     * @return void
     */
    public function test_get_all_schedules_not_being_logged()
    {
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->get('api/schedules')->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test get all schedules with a fake JWT Token.
     *
     * @return void
     */
    public function test_get_all_schedules_with_a_fake_jwt_token()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->fakeJwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->get('api/schedules')->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test logged contractor tries to cancel a pending schedule.
     *
     * @return void
     */
    public function test_contractor_tries_to_cancel_a_pending_schedule()
    {
        $authBody = [
            'login' => $this->contractor->login,
            'password' => $this->testPassword
        ];
        $authResponse = $this->post('api/login/contractor', $authBody)->assertStatus(Response::HTTP_OK);
        $jwtToken = 'Bearer '.$authResponse->getData()->access_token;

        $schedule = $this->createSchedules();

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->delete('api/schedules/'.$schedule->id)->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test logged advertiser tries to cancel a pending schedule.
     *
     * @return void
     */
    public function test_advertiser_tries_to_cancel_a_pending_schedule()
    {
        $authBody = [
            'login' => $this->advertiser->login,
            'password' => $this->testPassword
        ];
        $authResponse = $this->post('api/login/advertiser', $authBody)->assertStatus(Response::HTTP_OK);
        $jwtToken = 'Bearer '.$authResponse->getData()->access_token;

        $schedule = $this->createSchedules();

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->delete('api/schedules/'.$schedule->id)->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test not logged user tries to cancel a pending schedule.
     *
     * @return void
     */
    public function test_not_logged_user_tries_to_cancel_a_pending_schedule()
    {
        $schedule = $this->createSchedules();

        $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ])->delete('api/schedules/'.$schedule->id)->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test logged contractor tries to cancel an in progress schedule.
     *
     * @return void
     */
    public function test_contractor_tries_to_cancel_an_in_progress_schedule()
    {
        $authBody = [
            'login' => $this->contractor->login,
            'password' => $this->testPassword
        ];
        $authResponse = $this->post('api/login/contractor', $authBody)->assertStatus(Response::HTTP_OK);
        $jwtToken = 'Bearer '.$authResponse->getData()->access_token;

        $schedule = $this->createSchedules(['status' => Schedule::STATUS_IN_PROGRESS]);

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->delete('api/schedules/'.$schedule->id)->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test logged contractor tries to cancel a finished schedule.
     *
     * @return void
     */
    public function test_contractor_tries_to_cancel_a_finished_schedule()
    {
        $authBody = [
            'login' => $this->contractor->login,
            'password' => $this->testPassword
        ];
        $authResponse = $this->post('api/login/contractor', $authBody)->assertStatus(Response::HTTP_OK);
        $jwtToken = 'Bearer '.$authResponse->getData()->access_token;

        $schedule = $this->createSchedules(['status' => Schedule::STATUS_FINISHED]);

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->delete('api/schedules/'.$schedule->id)->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
