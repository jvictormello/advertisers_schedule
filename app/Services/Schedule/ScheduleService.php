<?php

namespace App\Services\Schedule;

use App\Jobs\SendCanceledScheduleNotification;
use App\Models\Schedule;
use App\Repositories\Schedule\ScheduleRepositoryContract;
use App\Services\Notification\NotificationServiceContract;
use App\Strategies\Schedule\InProgressStatusChangeStrategy;
use App\Strategies\Schedule\PendingStatusChangeStrategy;
use Exception;
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

    public function updateScheduleStatus(int $scheduleId)
    {
        if (!Auth::guard('advertisers')->check() || !Auth::guard('advertisers')->user()) {
            throw new UnauthorizedException('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
        $advertiserId = Auth::guard('advertisers')->user()->id;

        $schedule = $this->scheduleRepository->getById($scheduleId);
        if ($schedule->advertiser_id != $advertiserId) {
            throw new UnauthorizedException('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        $currentStatus = $schedule->status;
        if($currentStatus == Schedule::STATUS_FINISHED) {
            throw new Exception("The Schedule is already closed", Response::HTTP_METHOD_NOT_ALLOWED);
        }

        $statusChangeStrategies = [
            Schedule::STATUS_PENDING => new PendingStatusChangeStrategy(),
            Schedule::STATUS_IN_PROGRESS => new InProgressStatusChangeStrategy(),
        ];

        $statusChangeStrategy = $statusChangeStrategies[$currentStatus];
        $statusCanBeChanged = $statusChangeStrategy->canChangeStatus($schedule);

        if (!$statusCanBeChanged) {
            throw new Exception("The Schedule can't have the status changed yet", Response::HTTP_METHOD_NOT_ALLOWED);
        }

        $nextAllowedStatus = $statusChangeStrategy->getNextAllowedStatus();
        $updatedAttributesAndValues = $statusChangeStrategy->getUpdatedAttributesAndValues($schedule);

        $this->scheduleRepository->updateById($updatedAttributesAndValues, $schedule->id);

        return $nextAllowedStatus;
    }
}
