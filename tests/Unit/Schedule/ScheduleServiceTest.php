<?php

namespace Tests\Unit\Schedule;

use App\Jobs\SendCanceledScheduleNotification;
use App\Models\Advertiser;
use App\Models\Contractor;
use App\Models\Schedule;
use App\Services\Authentication\AuthenticationServiceContract;
use App\Services\Schedule\ScheduleServiceContract;
use Database\Seeders\DatabaseSeeder;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ScheduleServiceTest extends TestCase
{
    use RefreshDatabase;

    private $scheduleService;
    private $authenticationService;
    private $advertiser;
    private $contractor;
    private $testPassword;

    public function setUp(): void
    {
        parent::setUp();
        $this->scheduleService = app()->make(ScheduleServiceContract::class);
        $this->authenticationService = app()->make(AuthenticationServiceContract::class);
        $this->seed(DatabaseSeeder::class);
        $this->advertiser = Advertiser::first();
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
            'login' => $this->advertiser->login,
            'password' => $this->testPassword
        ];

        $this->authenticationService->loginAdvertiser($credentials);
        Auth::guard('advertisers')->attempt($credentials);

        $schedules = $this->scheduleService->getAllSchedulesByAdvertiserAndFilters();

        $advertiserIsTheOwner = true;
        foreach ($schedules as $schedule) {
            if ($schedule->advertiser_id != $this->advertiser->id) {
                $advertiserIsTheOwner = false;
            }
        }
        $this->assertTrue($advertiserIsTheOwner);
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

        $this->authenticationService->loginContractor($credentials);
        Auth::guard('contractors')->attempt($credentials);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->scheduleService->getAllSchedulesByAdvertiserAndFilters();
    }

    /**
     * Test getAllSchedulesByAdvertiserAndFilters method not logged.
     *
     * @return void
     */
    public function test_get_all_schedules_by_advertiser_method_with_not_logged()
    {
        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->scheduleService->getAllSchedulesByAdvertiserAndFilters();
    }

    /**
     * Test deleteSchedule method passing a pending schedule.
     *
     * @return void
     */
    public function test_delete_schedule_method_passing_a_pending_schedule()
    {
        Bus::fake();
        $schedule = $this->createSchedules(['status' => Schedule::STATUS_PENDING]);

        $this->scheduleService->deleteSchedule($schedule->id);

        Bus::assertDispatched(SendCanceledScheduleNotification::class);
        $this->assertTrue(true);
    }

    /**
     * Test deleteSchedule method passing an in progress schedule.
     *
     * @return void
     */
    public function test_delete_schedule_method_passing_an_in_progress_schedule()
    {
        Bus::fake();
        $schedule = $this->createSchedules(['status' => Schedule::STATUS_IN_PROGRESS]);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->scheduleService->deleteSchedule($schedule->id);
        Bus::assertNothingDispatched();
    }

    /**
     * Test deleteSchedule method passing a finished schedule.
     *
     * @return void
     */
    public function test_delete_schedule_method_passing_a_finished_schedule()
    {
        Bus::fake();
        $schedule = $this->createSchedules(['status' => Schedule::STATUS_FINISHED]);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->scheduleService->deleteSchedule($schedule->id);
        Bus::assertNothingDispatched();
    }
}
