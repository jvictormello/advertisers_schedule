<?php

namespace Tests\Feature\Schedule;

use App\Models\Advertiser;
use App\Models\Contractor;
use App\Models\Schedule;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    private $advertiser;
    private $anotherAdvertiser;
    private $contractor;
    private $testPassword;
    private $fakeJwtToken;
    private $twoHours;
    private $threeHours;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->advertiser = Advertiser::first();
        $this->anotherAdvertiser = $this->createAdvertisers();
        $this->contractor = Contractor::first();
        $this->testPassword = 'abcd1234';
        $this->twoHours = 2;
        $this->threeHours = 3;
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
        $jwtToken = 'Bearer '.$this->be($this->advertiser, 'advertisers')->fakeJwtToken;

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
     * Test logged contractor tries to get all the schedules.
     *
     * @return void
     */
    public function test_contractor_tries_to_get_all_the_schedules()
    {
        $jwtToken = 'Bearer '.$this->be($this->contractor, 'contractors')->fakeJwtToken;

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
        $jwtToken = 'Bearer '.$this->be($this->contractor, 'contractors')->fakeJwtToken;

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
        $jwtToken = 'Bearer '.$this->be($this->advertiser, 'advertisers')->fakeJwtToken;

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
        $jwtToken = 'Bearer '.$this->be($this->contractor, 'contractors')->fakeJwtToken;

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
        $jwtToken = 'Bearer '.$this->be($this->contractor, 'contractors')->fakeJwtToken;

        $schedule = $this->createSchedules(['status' => Schedule::STATUS_FINISHED]);

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->delete('api/schedules/'.$schedule->id)->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test logged advertiser tries to move a pending schedule to in progress.
     *
     * @return void
     */
    public function test_advertiser_tries_to_move_a_pending_schedule_to_in_progress()
    {
        $jwtToken = 'Bearer '.$this->be($this->advertiser, 'advertisers')->fakeJwtToken;

        $date = Carbon::now();
        $startsAt = clone $date;
        $finishesAt = clone $date;
        $schedule = $this->createSchedules([
            'date' => $date->format('Y-m-d'),
            'duration' => $this->threeHours,
            'starts_at' => $startsAt->format('Y-m-d H:i:s'),
            'finishes_at' => $finishesAt->addHours($this->threeHours)->format('Y-m-d H:i:s'),
            'status' => Schedule::STATUS_PENDING,
        ]);

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->put('api/schedules/'.$schedule->id.'/update-status')->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test another logged advertiser tries to move a pending schedule to in progress.
     *
     * @return void
     */
    public function test_another_logged_advertiser_tries_to_move_a_pending_schedule_to_in_progress()
    {
        $jwtToken = 'Bearer '.$this->be($this->anotherAdvertiser, 'advertisers')->fakeJwtToken;

        $date = Carbon::now();
        $startsAt = clone $date;
        $finishesAt = clone $date;
        $schedule = $this->createSchedules([
            'date' => $date->format('Y-m-d'),
            'duration' => $this->threeHours,
            'starts_at' => $startsAt->format('Y-m-d H:i:s'),
            'finishes_at' => $finishesAt->addHours($this->threeHours)->format('Y-m-d H:i:s'),
            'status' => Schedule::STATUS_PENDING,
        ]);

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->put('api/schedules/'.$schedule->id.'/update-status')->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test logged advertiser tries to move in progress schedule to finished.
     *
     * @return void
     */
    public function test_logged_advertiser_tries_to_move_in_progress_schedule_to_finished()
    {
        $jwtToken = 'Bearer '.$this->be($this->advertiser, 'advertisers')->fakeJwtToken;

        $date = Carbon::now();
        $startsAt = clone $date;
        $startedAt = clone $date;
        $finishesAt = clone $date;
        $schedule = $this->createSchedules([
            'date' => $date->format('Y-m-d'),
            'duration' => $this->threeHours,
            'starts_at' => $startsAt->subHours($this->threeHours)->format('Y-m-d H:i:s'),
            'started_at' => $startedAt->subHours($this->threeHours)->format('Y-m-d H:i:s'),
            'finishes_at' => $finishesAt->format('Y-m-d H:i:s'),
            'status' => Schedule::STATUS_IN_PROGRESS,
        ]);

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->put('api/schedules/'.$schedule->id.'/update-status')->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test logged advertiser tries to move in progress schedule to finished with less duration than expected.
     *
     * @return void
     */
    public function test_logged_advertiser_tries_to_move_in_progress_schedule_to_finished_with_less_duration_than_expected()
    {
        $jwtToken = 'Bearer '.$this->be($this->advertiser, 'advertisers')->fakeJwtToken;

        $date = Carbon::now();
        $startsAt = clone $date;
        $startedAt = clone $date;
        $finishesAt = clone $date;
        $schedule = $this->createSchedules([
            'date' => $date->format('Y-m-d'),
            'duration' => $this->threeHours,
            'starts_at' => $startsAt->subHours($this->threeHours)->format('Y-m-d H:i:s'),
            'started_at' => $startedAt->subHours($this->twoHours)->format('Y-m-d H:i:s'),
            'finishes_at' => $finishesAt->format('Y-m-d H:i:s'),
            'status' => Schedule::STATUS_IN_PROGRESS,
        ]);

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->put('api/schedules/'.$schedule->id.'/update-status')->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * Test logged advertiser tries to move a finished schedule to next status.
     *
     * @return void
     */
    public function test_logged_advertiser_tries_to_move_a_finished_schedule_to_next_status()
    {
        $jwtToken = 'Bearer '.$this->be($this->advertiser, 'advertisers')->fakeJwtToken;

        $date = Carbon::now();
        $startsAt = clone $date;
        $startedAt = clone $date;
        $finishesAt = clone $date;
        $schedule = $this->createSchedules([
            'date' => $date->format('Y-m-d'),
            'duration' => $this->threeHours,
            'starts_at' => $startsAt->subHours($this->threeHours)->format('Y-m-d H:i:s'),
            'started_at' => $startedAt->subHours($this->threeHours)->format('Y-m-d H:i:s'),
            'finishes_at' => $finishesAt->format('Y-m-d H:i:s'),
            'status' => Schedule::STATUS_FINISHED,
        ]);

        $this->withHeaders([
            'Authorization' => $jwtToken,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->put('api/schedules/'.$schedule->id.'/update-status')->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
