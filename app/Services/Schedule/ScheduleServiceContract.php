<?php

namespace App\Services\Schedule;

interface ScheduleServiceContract
{
    public function getAllSchedulesByAdvertiserIdAndFilters(array $filters = []);
}
