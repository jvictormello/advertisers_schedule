<?php

namespace App\Services\Schedule;

use App\Repositories\Schedule\ScheduleRepositoryContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class ScheduleService implements ScheduleServiceContract
{
    protected $scheduleRepository;

    public function __construct(ScheduleRepositoryContract $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function getAllSchedulesByAdvertiserAndFilters(array $filters = [])
    {
        if (!Auth::guard('advertisers')->check() || !Auth::guard('advertisers')->user()) {
            throw new UnauthorizedException('Not authorized', Response::HTTP_UNAUTHORIZED);
        }

        $advertiserId = Auth::guard('advertisers')->user()->id;

        return $this->scheduleRepository->allSchedulesByAdvertiserIdAndFilters($advertiserId, $filters)->with('contractor')->get();
    }
}
