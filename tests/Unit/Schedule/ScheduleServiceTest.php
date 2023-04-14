<?php

namespace Tests\Unit\Schedule;

use App\Jobs\SendCanceledScheduleNotification;
use App\Models\Advertiser;
use App\Models\Contractor;
use App\Models\Schedule;
use App\Services\Schedule\ScheduleServiceContract;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ScheduleServiceTest extends TestCase
{
    use RefreshDatabase;

    private $scheduleService;
    private $advertiser;
    private $contractor;
    private $testPassword;
    private $twoHours;
    private $threeHours;

    public function setUp(): void
    {
        parent::setUp();
        $this->scheduleService = app()->make(ScheduleServiceContract::class);
        $this->seed(DatabaseSeeder::class);
        $this->advertiser = Advertiser::first();
        $this->contractor = Contractor::first();
        $this->testPassword = 'abcd1234';
        $this->twoHours = 2;
        $this->threeHours = 3;
    }

    /**
     * Test getAllSchedulesByAdvertiserAndFilters method with Advertiser info.
     *
     * @return void
     */
    public function test_get_all_schedules_by_advertiser_method_with_advertiser_info()
    {
        $this->be($this->advertiser, 'advertisers');

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
        $this->be($this->contractor, 'contractors');

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

    /**
     * Test updateScheduleStatus method from pending to in progress with an authenticated advertiser.
     *
     * @return void
     */
    public function test_update_schedule_status_method_from_pending_to_in_progress_with_an_authenticated_advertiser()
    {
        $this->be($this->advertiser, 'advertisers');
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

        $this->scheduleService->updateScheduleStatus($schedule->id);
        $this->assertTrue(true);
    }

    /**
     * Test updateScheduleStatus method from pending to in progress with an authenticated contractor.
     *
     * @return void
     */
    public function test_update_schedule_status_method_from_pending_to_in_progress_with_an_authenticated_contractor()
    {
        $this->be($this->contractor, 'contractors');
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

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->scheduleService->updateScheduleStatus($schedule->id);
    }

    /**
     * Test updateScheduleStatus method with a no authenticated user.
     *
     * @return void
     */
    public function test_update_schedule_status_method_with_a_no_authenticated_user()
    {
        $date = Carbon::now();
        $startsAt = clone $date;
        $finishesAt = clone $date;
        $schedule = $this->createSchedules([
            'date' => $date->format('Y-m-d'),
            'duration' => $this->threeHours,
            'starts_at' => $startsAt->format('Y-m-d H:i:s'),
            'finishes_at' => $finishesAt->addHours($this->threeHours)->format('Y-m-d H:i:s'),
            'status' => Schedule::STATUS_IN_PROGRESS,
        ]);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->scheduleService->updateScheduleStatus($schedule->id);
    }

    /**
     * Test updateScheduleStatus method with another authenticated advertiser.
     *
     * @return void
     */
    public function test_update_schedule_status_method_with_another_authenticated_advertiser()
    {
        $anotherUser = $this->createAdvertisers();
        $this->be($anotherUser, 'advertisers');
        $date = Carbon::now();
        $startsAt = clone $date;
        $finishesAt = clone $date;
        $schedule = $this->createSchedules([
            'date' => $date->format('Y-m-d'),
            'duration' => $this->threeHours,
            'starts_at' => $startsAt->format('Y-m-d H:i:s'),
            'finishes_at' => $finishesAt->addHours($this->threeHours)->format('Y-m-d H:i:s'),
            'status' => Schedule::STATUS_IN_PROGRESS,
        ]);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->scheduleService->updateScheduleStatus($schedule->id);
    }

    /**
     * Test updateScheduleStatus method from finished to next status with an authenticated contractor.
     *
     * @return void
     */
    public function test_update_schedule_status_method_from_finished_to_next_status()
    {
        $this->be($this->advertiser, 'advertisers');
        $date = Carbon::now();
        $startsAt = clone $date;
        $finishesAt = clone $date;
        $schedule = $this->createSchedules([
            'date' => $date->format('Y-m-d'),
            'duration' => $this->threeHours,
            'starts_at' => $startsAt->format('Y-m-d H:i:s'),
            'finishes_at' => $finishesAt->addHours($this->threeHours)->format('Y-m-d H:i:s'),
            'status' => Schedule::STATUS_FINISHED,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The Schedule is already closed');
        $this->expectExceptionCode(Response::HTTP_METHOD_NOT_ALLOWED);
        $this->scheduleService->updateScheduleStatus($schedule->id);
    }

    /**
     * Test updateScheduleStatus method from pending to in progress with an authenticated contractor.
     *
     * @return void
     */
    public function test_update_schedule_status_method_cant_be_changed_from_pending_to_in_progress()
    {
        $this->be($this->advertiser, 'advertisers');
        $date = Carbon::now();
        $startsAt = clone $date;
        $finishesAt = clone $date;
        $schedule = $this->createSchedules([
            'date' => $date->format('Y-m-d'),
            'duration' => $this->threeHours - $this->twoHours,
            'starts_at' => $startsAt->addHours($this->twoHours)->format('Y-m-d H:i:s'),
            'finishes_at' => $finishesAt->addHours($this->threeHours)->format('Y-m-d H:i:s'),
            'status' => Schedule::STATUS_PENDING,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The Schedule can\'t have the status changed yet');
        $this->expectExceptionCode(Response::HTTP_METHOD_NOT_ALLOWED);
        $this->scheduleService->updateScheduleStatus($schedule->id);
    }
    /**
     * Test updateScheduleStatus method from in progress to finished with an authenticated contractor.
     *
     * @return void
     */
    public function test_update_schedule_status_method_cant_be_changed_from_in_progress_to_finished()
    {
        $this->be($this->advertiser, 'advertisers');
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

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The Schedule is already closed');
        $this->expectExceptionCode(Response::HTTP_METHOD_NOT_ALLOWED);
        $this->scheduleService->updateScheduleStatus($schedule->id);
    }
}
