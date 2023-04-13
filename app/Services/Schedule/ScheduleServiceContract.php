<?php

namespace App\Services\Schedule;

interface ScheduleServiceContract
{
    public function getAllSchedulesByAdvertiserAndFilters(array $filters = []);
    public function deleteSchedule(int $scheduleId);
    public function getScheduleById(int $scheduleId);
}
