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

}
