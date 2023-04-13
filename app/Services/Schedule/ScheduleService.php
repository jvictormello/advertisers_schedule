<?php

namespace App\Services\Schedule;

use App\Jobs\SendCanceledScheduleNotification;
use App\Models\Schedule;
use App\Repositories\Schedule\ScheduleRepositoryContract;
use App\Services\Notification\NotificationServiceContract;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ScheduleService implements ScheduleServiceContract
{
    protected $scheduleRepository;
    protected $notificationService;

    public function __construct(ScheduleRepositoryContract $scheduleRepository, NotificationServiceContract $notificationServiceContract)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->notificationService = $notificationServiceContract;
    }

    public function getAllSchedulesByAdvertiserAndFilters(array $filters = [])
    {
        if (!Auth::guard('advertisers')->check() || !Auth::guard('advertisers')->user()) {
            throw new Exception('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        $advertiserId = Auth::guard('advertisers')->user()->id;

        return $this->scheduleRepository->allSchedulesByAdvertiserIdAndFilters($advertiserId, $filters)->with('contractor')->get();
    }

    public function deleteSchedule(Schedule $schedule)
    {
        if ($schedule->status != Schedule::STATUS_PENDING) {
            throw new Exception('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        if ($this->scheduleRepository->deleteSchedule($schedule->id)) {
            // I'm going to let this command with the dispatchSync instead of dispacth because it's easier to test
            SendCanceledScheduleNotification::dispatchSync($this->notificationService, $schedule);
        }
    }

    public function getScheduleById(int $scheduleId)
    {
        $this->scheduleRepository->getById($scheduleId);
    }
}
