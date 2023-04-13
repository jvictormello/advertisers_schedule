<?php

namespace App\Repositories\Schedule;

use App\Models\Schedule;
use App\Repositories\BaseRepositoryEloquent;

class ScheduleRepositoryEloquent extends BaseRepositoryEloquent implements ScheduleRepositoryContract
{
    protected $model;

    public function __construct(Schedule $schedule)
    {
        $this->model = $schedule;
    }

    public function allSchedulesByAdvertiserIdAndFilters(int $advertiserId, array $filters)
    {
        $queryBuilder = $this->model->where('advertiser_id', $advertiserId);

        foreach ($filters as $filterName => $filterValue) {
            $queryBuilder = $queryBuilder->where($filterName, $filterValue);
        }

        return $queryBuilder;
    }

    public function deleteSchedule(int $scheduleId)
    {
        $this->updateById(['status' => Schedule::STATUS_FINISHED], $scheduleId);
        return $this->delete($scheduleId);
    }
}
