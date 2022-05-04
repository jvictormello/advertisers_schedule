<?php

namespace App\Services;

use App\Repositories\Contracts\AvailabilitiesRepositoryContract;
use App\Services\Contracts\AvailabilitiesServiceContract;
use Illuminate\Support\Collection;

class AvailabilitiesService implements AvailabilitiesServiceContract
{
    private $availabilitiesRepository;
    private const WEEK_DAY_TRANSLATION = [
        'Domingo',
        'Segunda-feira',
        'Terça-feira',
        'Quarta-feira',
        'Quinta-feira',
        'Sexta-feira',
        'Sábado'
    ];

    public function __construct(AvailabilitiesRepositoryContract $availabilitiesRepository)
    {
        $this->availabilitiesRepository = $availabilitiesRepository;
    }

    public function searchByAdvertiserId(int $id): Collection
    {
        return $this->makeAvailabilitiesColletion($this->availabilitiesRepository->searchByAdvertiserId($id));
    }

    public function searchByAvailabilityId(int $id): Collection
    {
        return $this->makeAvailabilitiesColletion($this->availabilitiesRepository->searchByAvailabilityId($id));
    }

    private function makeAvailabilitiesColletion(Collection $availabilitiesCollection): Collection
    {
        if(count($availabilitiesCollection) == 0) {
            return $availabilitiesCollection;
        }

        $advertiserInfo = new Collection([
            'advertiser' => $availabilitiesCollection->first()->advertisers,
            'availabilities' => new Collection()
        ]);

        foreach($availabilitiesCollection as $availability) {
            $item = [
                'id' => $availability->id,
                'week_day' => $this->translateWeekDay($availability->week_day),
                'hour_start' => $this->timetoHour($availability->start_time),
                'hour_end' => $this->timetoHour($availability->end_time),
            ];
            $advertiserInfo['availabilities']->add($item);
        }

        return $advertiserInfo;
    }

    private function translateWeekDay(int $weekDay): string
    {
        return self::WEEK_DAY_TRANSLATION[$weekDay];
    }

    private function timetoHour(string $time): string
    {
        return Date('H', strtotime($time));
    }
}
