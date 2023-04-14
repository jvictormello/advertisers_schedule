<?php

namespace App\Strategies\Schedule;

use App\Models\Schedule;
use Carbon\Carbon;

class PendingStatusChangeStrategy implements ScheduleStatusChangeStrategyContract
{
    private $currentDateTime;
    private $startsAtDateTime;

    public function canChangeStatus(Schedule $schedule)
    {
        $this->currentDateTime = Carbon::now();
        $this->startsAtDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $schedule->starts_at);

        if ($this->currentDateTime >= $this->startsAtDateTime) {
            return true;
        }

        return false;
    }

        public function getNextAllowedStatus()
    {
        return Schedule::STATUS_IN_PROGRESS;
    }

    public function getUpdatedAttributesAndValues(Schedule $schedule)
    {
        return [
            'started_at' => $this->currentDateTime->format('Y-m-d H:i:s'),
            'status' => $this->getNextAllowedStatus(),
        ];
    }
}
