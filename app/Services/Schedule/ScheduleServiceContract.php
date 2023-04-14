<?php

namespace App\Services\Schedule;

interface ScheduleServiceContract
{
    public function getAllSchedulesByAdvertiserAndFilters(array $filters = []);
    public function deleteSchedule(int $scheduleId);
    public function updateScheduleStatus(int $scheduleId);
    public function generateDailySummary(string $date, string $fieldName, string $fieldValue);
}
