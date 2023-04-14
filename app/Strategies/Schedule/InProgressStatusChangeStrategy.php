<?php

namespace App\Strategies\Schedule;

use App\Models\Schedule;
use Carbon\Carbon;

class InProgressStatusChangeStrategy implements ScheduleStatusChangeStrategyContract
{
    const MAX_SCHEDULE_DURATION_IN_HOURS = 3;

    private $currentDateTime;
    private $startsAtDateTime;
    private $finishesAtDateTime;
    private $startedAtDateTime;
    private $expectedDurationInMinutes;
    private $currentDurationInMinutes;

    public function canChangeStatus(Schedule $schedule)
    {
        $this->currentDateTime = Carbon::now();
        $this->startsAtDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $schedule->starts_at);
        $this->finishesAtDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $schedule->finishes_at);
        $this->startedAtDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $schedule->started_at);
        $this->expectedDurationInMinutes = $this->startsAtDateTime->diffInMinutes($this->finishesAtDateTime, false);
        $this->currentDurationInMinutes = $this->startedAtDateTime->diffInMinutes($this->currentDateTime, false);

        if ($this->currentDurationInMinutes >= $this->expectedDurationInMinutes) {
            return true;
        }

        return false;
    }

    public function getNextAllowedStatus()
    {
        return Schedule::STATUS_FINISHED;
    }

    public function getUpdatedAttributesAndValues(Schedule $schedule)
    {
        $currentDurationInHours = $this->startedAtDateTime->diffInHours($this->currentDateTime, false);
        $overtimeInHours = $this->getOvertimeInHours($currentDurationInHours);
        $hoursWithNormalPrice = $currentDurationInHours - $overtimeInHours;

        // Get the related values from DB using Eloquent
        $discountAmount = $schedule->advertiser->discounts->where('hours', $hoursWithNormalPrice)->first()->amount;
        $hourAmount = $schedule->advertiser->prices->first()->amount;
        $overtimeAmount = $schedule->advertiser->overtimes->first()->amount;

        // Calculate Amounts based in pricePerHour * hours
        $hoursAmount = $hourAmount * $hoursWithNormalPrice;
        $overtimesAmount = $overtimeAmount * $overtimeInHours;

        // Calculate the amount
        $amount = $hoursAmount - $discountAmount + $overtimesAmount;

        return [
            'duration' => $currentDurationInHours,
            'finished_at' => $this->currentDateTime,
            'status' => $this->getNextAllowedStatus(),
            'amount' => $amount,
        ];
    }

    public static function getOvertimeInHours(int $currentDuration) {
        if ($currentDuration > self::MAX_SCHEDULE_DURATION_IN_HOURS) {
            return $currentDuration - self::MAX_SCHEDULE_DURATION_IN_HOURS;
        }
        return 0;
    }
}
