<?php

namespace App\Services\Schedule;

use App\Repositories\Schedule\ScheduleRepositoryContract;

class ScheduleService implements ScheduleServiceContract
{
    protected $scheduleRepository;

    public function __construct(ScheduleRepositoryContract $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function getAllSchedules()
    {
        return $this->scheduleRepository->all()->toArray();
    }

    public function getScheduleById(int $scheduleId)
    {
        return $this->scheduleRepository->getById($scheduleId);
    }
}
