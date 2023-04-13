<?php

namespace App\Services\Schedule;

use App\Jobs\SendCanceledScheduleNotification;
use App\Models\Schedule;
use App\Repositories\Schedule\ScheduleRepositoryContract;
use App\Services\Notification\NotificationServiceContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
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
            throw new UnauthorizedException('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        $advertiserId = Auth::guard('advertisers')->user()->id;

        return $this->scheduleRepository->allSchedulesByAdvertiserIdAndFilters($advertiserId, $filters)->with('contractor')->get();
    }

    public function deleteSchedule(int $scheduleId)
    {
        $schedule = $this->scheduleRepository->getById($scheduleId);
        if ($schedule->status != Schedule::STATUS_PENDING) {
            throw new UnauthorizedException('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        if ($this->scheduleRepository->deleteSchedule($schedule->id)) {
            SendCanceledScheduleNotification::dispatch($this->notificationService, $schedule);
        }
    }

    public function getScheduleById(int $scheduleId)
    {
        $this->scheduleRepository->getById($scheduleId);
    }
}
