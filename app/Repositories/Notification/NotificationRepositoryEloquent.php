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

    public function getAllByAdvertiserId(int $advertiserId)
    {
        $queryBuilder = $this->model->leftJoin('schedules', 'notifications.schedule_id', '=', 'schedules.id');
        $queryBuilder = $queryBuilder->where('schedules.advertiser_id', $advertiserId);

        return $queryBuilder;
    }
}
