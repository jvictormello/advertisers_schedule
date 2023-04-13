<?php

namespace Tests\Unit\Schedule;

use App\Models\Advertiser;
use App\Models\Contractor;
use App\Models\Schedule;
use App\Services\Authentication\AuthenticationServiceContract;
use App\Services\Schedule\ScheduleServiceContract;
use Database\Seeders\DatabaseSeeder;
use Auth;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ScheduleServiceTest extends TestCase
{
    use RefreshDatabase;

    private $scheduleService;
    private $authenticationService;
    private $advertiser1;
    private $contractor;
    private $testPassword;

    public function setUp(): void
    {
        parent::setUp();
        $this->scheduleService = app()->make(ScheduleServiceContract::class);
        $this->authenticationService = app()->make(AuthenticationServiceContract::class);
        $this->seed(DatabaseSeeder::class);
        $this->advertiser1 = Advertiser::first();
        $this->contractor = Contractor::first();
        $this->testPassword = 'abcd1234';
    }

    /**
     * Test getAllSchedulesByAdvertiserAndFilters method with Advertiser info.
     *
     * @return void
     */
    public function test_get_all_schedules_by_advertiser_method_with_advertiser_info()
    {
        $credentials = [
            'login' => $this->advertiser1->login,
            'password' => $this->testPassword
        ];

        try {
            $this->authenticationService->loginAdvertiser($credentials);
            Auth::guard('advertisers')->attempt($credentials);

            $schedule = $this->scheduleService->getAllSchedulesByAdvertiserAndFilters();

            $advertiser1IsTheOwner = true;
            foreach ($schedule as $schedule) {
                if ($schedule->advertiser_id != $this->advertiser1->id) {
                    $advertiser1IsTheOwner = false;
                }
            }
            $this->assertTrue($advertiser1IsTheOwner);
        } catch (Exception $exception) {
            $this->assertNull($exception);
        }
    }

    /**
     * Test getAllSchedulesByAdvertiserAndFilters method with Contractor info.
     *
     * @return void
     */
    public function test_get_all_schedules_by_advertiser_method_with_contractor_info()
    {
        $credentials = [
            'login' => $this->contractor->login,
            'password' => $this->testPassword
        ];

        try {
            $this->authenticationService->loginContractor($credentials);
            Auth::guard('contractors')->attempt($credentials);

            $this->scheduleService->getAllSchedulesByAdvertiserAndFilters();
        } catch (Exception $exception) {
            $this->assertNotNull($exception);
            $this->assertEquals('Unauthorized', $exception->getMessage());
            $this->assertEquals(Response::HTTP_UNAUTHORIZED, $exception->getCode());
        }
    }

    /**
     * Test getAllSchedulesByAdvertiserAndFilters method not logged.
     *
     * @return void
     */
    public function test_get_all_schedules_by_advertiser_method_with_not_logged()
    {
        try {
            $this->scheduleService->getAllSchedulesByAdvertiserAndFilters();
        } catch (Exception $exception) {
            $this->assertNotNull($exception);
            $this->assertEquals('Unauthorized', $exception->getMessage());
            $this->assertEquals(Response::HTTP_UNAUTHORIZED, $exception->getCode());
        }
    }

    // hhaha
    /**
     * Test deleteSchedule method passing a pending schedule.
     *
     * @return void
     */
    public function test_delete_schedule_method_passing_a_pending_schedule()
    {
        $schedule = $this->createSchedules(['status' => Schedule::STATUS_PENDING]);

        $deleted = false;
        try {
            $this->scheduleService->deleteSchedule($schedule);
            $deleted = true;
        } catch (Exception $exception) {
            $this->assertNull($exception);
        }

        $this->assertTrue($deleted);
    }

    /**
     * Test deleteSchedule method passing an in progress schedule.
     *
     * @return void
     */
    public function test_delete_schedule_method_passing_an_in_progress_schedule()
    {
        $schedule = $this->createSchedules(['status' => Schedule::STATUS_IN_PROGRESS]);

        $deleted = false;
        try {
            $this->scheduleService->deleteSchedule($schedule);
            $deleted = true;
        } catch (Exception $exception) {
            $this->assertNotNull($exception);
            $this->assertFalse($deleted);
        }
    }

    /**
     * Test deleteSchedule method passing a finished schedule.
     *
     * @return void
     */
    public function test_delete_schedule_method_passing_a_finished_schedule()
    {
        $schedule = $this->createSchedules(['status' => Schedule::STATUS_FINISHED]);

        $deleted = false;
        try {
            $this->scheduleService->deleteSchedule($schedule);
            $deleted = true;
        } catch (Exception $exception) {
            $this->assertNotNull($exception);
            $this->assertFalse($deleted);
        }
    }
}
