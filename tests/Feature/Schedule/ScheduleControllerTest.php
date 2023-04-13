<?php

namespace Tests\Feature\Schedule;

use App\Models\Advertiser;
use App\Models\Contractor;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    private $advertiser1;
    private $contractor;
    private $testPassword;
    private $fakeJwtToken;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->advertiser1 = Advertiser::first();
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
            'login' => $this->advertiser1->login,
            'password' => $this->testPassword
        ];
        $authResponse = $this->post('api/login/advertiser', $authBody)->assertStatus(Response::HTTP_OK);
        $jwtToken = 'Bearer '.$authResponse->getData()->access_token;

        $response = $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->get('api/schedules')->assertStatus(Response::HTTP_OK);

        $advertiser1IsTheOwner = true;
        foreach ($response->getData() as $schedule) {
            if ($schedule->advertiser_id != $this->advertiser1->id) {
                $advertiser1IsTheOwner = false;
            }
        }

        $this->assertTrue($advertiser1IsTheOwner);
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
}
