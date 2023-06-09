<?php

namespace App\Repositories\Notification;

use App\Repositories\BaseRepositoryContract;

interface NotificationRepositoryContract extends BaseRepositoryContract
{
    public function getAllByAdvertiserId(int $advertiserId);
}
