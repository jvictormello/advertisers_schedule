<?php

namespace App\Services\Schedule;

interface ScheduleServiceContract
{
    public function getAllSchedules();
    public function getScheduleById(int $scheduleId);
}
