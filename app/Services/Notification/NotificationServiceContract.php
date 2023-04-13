<?php

namespace App\Services\Notification;

interface NotificationServiceContract
{
    public function createNotification(array $notificationData);
    public function getAllNotifications();
}
