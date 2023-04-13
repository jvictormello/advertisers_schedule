<?php

namespace App\Services\Notification;

use App\Repositories\Notification\NotificationRepositoryContract;

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
        return ['teste' => 'teste'];
    }
}
