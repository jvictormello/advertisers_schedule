<?php

namespace App\Services\Schedule;

use App\Models\Schedule;

interface ScheduleServiceContract
{
    public function getAllSchedulesByAdvertiserAndFilters(array $filters = []);
    public function deleteSchedule(Schedule $schedule);
    public function getScheduleById(int $scheduleId);
}
