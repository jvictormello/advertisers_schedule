<?php

namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Repositories\BaseRepositoryEloquent;

class NotificationRepositoryEloquent extends BaseRepositoryEloquent implements NotificationRepositoryContract
{
    protected $model;

    public function __construct(Notification $notification)
    {
        $this->model = $notification;
    }
}
