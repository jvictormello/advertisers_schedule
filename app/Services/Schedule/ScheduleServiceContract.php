<?php

namespace App\Services\Schedule;

interface ScheduleServiceContract
{
    public function getAllSchedulesByAdvertiserAndFilters(array $filters = []);
}
