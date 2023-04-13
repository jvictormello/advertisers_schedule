<?php

namespace App\Repositories\Schedule;

use App\Repositories\BaseRepositoryContract;

interface ScheduleRepositoryContract extends BaseRepositoryContract
{
    public function allSchedulesByAdvertiserIdAndFilters(int $advertiserId, array $filters);
}
