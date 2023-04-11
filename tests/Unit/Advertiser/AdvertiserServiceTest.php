<?php

namespace Tests\Unit\Advertiser;

use App\Models\Advertiser;
use App\Services\Advertiser\AdvertiserService;
use App\Services\Advertiser\AdvertiserServiceContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AdvertiserServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var int $firstAdvertiserId first valid advertiser ID.
     */
    private $firstAdvertiserId;
    
    /**
     * @var int $qtyAdvertisers Qty Advertisers for tests.
     */
    private $qtyAdvertisers;

    /**
     * @var AdvertiserServiceContract $advertiserService
     */
    private $advertiserService;

    public function setUp(): void
    {
        parent::setUp();
        $this->advertiserService = app()->make(AdvertiserServiceContract::class);
        $this->qtyAdvertisers = 10;
        $this->createAdvertisers([], $this->qtyAdvertisers);
        $this->firstAdvertiserId = 1;
    }

    /**
     * Test non cached Get All
     *
     * @return void
     */
    public function test_get_all_advertisers_without_caching()
    {
        $response = $this->advertiserService->getAllAdvertisers();
        $this->assertEquals($this->qtyAdvertisers, count($response));
        
        $cacheKey = AdvertiserService::REDIS_KEY_GET_ALL_ADVERTISERS;
        $cachedSearch = Cache::store('redis')->get(AdvertiserService::REDIS_KEY_GET_ALL_ADVERTISERS);
        
        $isCached = false;
        if ($cachedSearch && $cachedSearch[0]['email'] == $response[0]['email']) {
            $isCached = true;
        }
        $this->assertFalse($isCached);
    }

    /**
     * Test cached Get All
     *
     * @return void
     */
    public function test_get_all_advertisers_with_caching()
    {
        $response = $this->advertiserService->getAllCachedAdvertisers();
        $this->assertEquals($this->qtyAdvertisers, count($response));
        
        $cacheKey = AdvertiserService::REDIS_KEY_GET_ALL_ADVERTISERS;
        $cachedSearch = Cache::store('redis')->get($cacheKey);
        
        $isCached = false;
        if ($cachedSearch && $cachedSearch[0]['email'] == $response[0]['email']) {
            $isCached = true;
        }
        $this->assertTrue($isCached);

        $this->cleanCache($cacheKey);
    }
    
    /**
     * Test get Advertiser By Id
     *
     * @return void
     */
    public function test_get_advertisers_by_id_without_caching()
    {
        $response = $this->advertiserService->getAdvertiserById($this->firstAdvertiserId);
        $this->assertInstanceOf(Advertiser::class, $response);
        
        $cacheKey = AdvertiserService::REDIS_KEY_GET_ADVERTISER_BY_ID.$this->firstAdvertiserId;
        $cachedSearch = Cache::store('redis')->get($cacheKey);
        
        $isCached = false;
        if ($cachedSearch && $cachedSearch->email == $response->email) {
            $isCached = true;
        }
        $this->assertFalse($isCached);

        $this->cleanCache($cacheKey);
    }
    
    /**
     * Test get Advertiser By Id with Caching
     *
     * @return void
     */
    public function test_get_advertisers_by_id_with_caching()
    {
        $response = $this->advertiserService->getCachedAdvertiserById($this->firstAdvertiserId);
        $this->assertInstanceOf(Advertiser::class, $response);
        
        $cacheKey = AdvertiserService::REDIS_KEY_GET_ADVERTISER_BY_ID.$this->firstAdvertiserId;
        $cachedSearch = Cache::store('redis')->get($cacheKey);
        
        $isCached = false;
        if ($cachedSearch && $cachedSearch->email == $response->email) {
            $isCached = true;
        }
        $this->assertTrue($isCached);

        $this->cleanCache($cacheKey);
    }

}
