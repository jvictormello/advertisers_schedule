<?php

namespace Tests;

use App\Models\Advertiser;
use App\Models\Contractor;
use App\Models\Discount;
use App\Models\Overtime;
use App\Models\Price;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Cache;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function createAdvertisers(array $args = [], int $count = 1)
    {
        if ($count > 1) {
            return Advertiser::factory()->count($count)->create($args);
        }
        return Advertiser::factory()->create($args);
    }

    public function createContractors(array $args = [], int $count = 1)
    {
        if ($count > 1) {
            return Contractor::factory()->count($count)->create($args);
        }
        return Contractor::factory()->create($args);
    }

    public function createDiscounts(array $args = [], int $count = 1)
    {
        if ($count > 1) {
            return Discount::factory()->count($count)->create($args);
        }
        return Discount::factory()->create($args);
    }

    public function createOvertimes(array $args = [], int $count = 1)
    {
        if ($count > 1) {
            return Overtime::factory()->count($count)->create($args);
        }
        return Overtime::factory()->create($args);
    }

    public function createPrices(array $args = [], int $count = 1)
    {
        if ($count > 1) {
            return Price::factory()->count($count)->create($args);
        }
        return Price::factory()->create($args);
    }

    public function createSchedules(array $args = [], int $count = 1)
    {
        if ($count > 1) {
            return Schedule::factory()->count($count)->create($args);
        }
        return Schedule::factory()->create($args);
    }

    public function cleanCache(string $cacheKey) {
        Cache::store('redis')->forget($cacheKey);
    }
}
