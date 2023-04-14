<?php

namespace App\Strategies\Schedule;

use App\Models\Schedule;

interface ScheduleStatusChangeStrategyContract
{
    public function canChangeStatus(Schedule $schedule);
    public function getNextAllowedStatus();
    public function getUpdatedAttributesAndValues(Schedule $schedule);
}
