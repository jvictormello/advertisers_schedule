<?php

namespace Tests\Unit;

use App\Repositories\AvailabilitiesRepository;
use App\Services\AvailabilitiesService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AvailabilitiesTest extends TestCase
{
    private const ADVERTISER_ID = 1;
    private const ADVERTISER_NAME = 'John Doe';
    private const ADVERTISER_AGE = 30;
    private const AVALIABILITY_ID = 1;

    public function testAvailabilitiesService(): void
    {
        $availabilitiesRepositoryMock = $this->createMock(AvailabilitiesRepository::class);
        $availabilitiesRepositoryMock->method('searchByAdvertiserId')->willReturn($this->fakeAvailabilitiesCollectionMake());
        $availabilitiesService = new AvailabilitiesService($availabilitiesRepositoryMock);

        $expectedAvailabilities = new Collection();

        $expectedAvailabilities->add(
            [
                'id' => self::AVALIABILITY_ID,
                'week_day' => 'Segunda-feira',
                'hour_start' => 10,
                'hour_end' => 22
            ]
        );

        $expectedResponse = new Collection([
            'advertiser' => [
                'id' => self::ADVERTISER_ID,
                'name' => self::ADVERTISER_NAME,
                'age' => self::ADVERTISER_AGE
            ],
            'availabilities' => $expectedAvailabilities
        ]);

        $this->assertEquals($expectedResponse, $availabilitiesService->searchByAdvertiserId(1));
    }

    private function fakeAvailabilitiesCollectionMake(): Collection
    {
        $collection = new Collection();

        $avaliability = (object)[
            'id' => self::AVALIABILITY_ID,
            'advertiser_id' => self::ADVERTISER_ID,
            'week_day' => 1,
            'start_time' => '10:00',
            'end_time' => '22:00',
            'advertisers' => [
                'id' => self::ADVERTISER_ID,
                'name' => self::ADVERTISER_NAME,
                'age' => self::ADVERTISER_AGE
            ]
        ];

        $collection->add($avaliability);

        return $collection;
    }
}
