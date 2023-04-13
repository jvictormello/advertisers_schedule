<?php

namespace App\Services\Notification;

use App\Repositories\Notification\NotificationRepositoryContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class NotificationService implements NotificationServiceContract
{
    protected $notificationRepository;

    public function __construct(NotificationRepositoryContract $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function createNotification(array $notificationData)
    {
        $this->notificationRepository->store($notificationData);
    }

    public function getAllNotifications()
    {
        if (!Auth::guard('advertisers')->check() || !Auth::guard('advertisers')->user()) {
            throw new UnauthorizedException('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
        return $this->notificationRepository->getAllByAdvertiserId(1)->with('schedule')->get();
    }
}
