<?php

namespace Tests\Feature\Advertiser;

use App\Services\Advertiser\AdvertiserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AdvertiserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $advertiser1;
    private $advertiser2;
    private $nonExistentAdvertiserId;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->advertiser1 = $this->createAdvertisers();
        $this->advertiser2 = $this->createAdvertisers();
        $this->nonExistentAdvertiserId = 99999;
    }

    /**
     * Test get all advertisers and validate advertisers quantity.
     *
     * @return void
     */
    public function test_get_all_advertisers()
    {
        $response = $this->get('api/advertisers/')->assertStatus(Response::HTTP_OK);

        $this->assertEquals(2, count($response->getData()));
    }

    /**
     * Test get all is cached.
     *
     * @return void
     */
    public function test_get_all_advertisers_is_cached()
    {
        $response = $this->get('api/advertisers/')->assertStatus(Response::HTTP_OK);
        
        $cacheKey = AdvertiserService::REDIS_KEY_GET_ALL_ADVERTISERS;
        $cachedSearch = Cache::store('redis')->get($cacheKey);

        $this->assertNotNull($cachedSearch);
        $this->assertEquals(2, count($cachedSearch));
        foreach ($response->getData() as $advertiser) {
            $this->assertTrue(in_array((array)$advertiser, $cachedSearch));
        }

        $this->cleanCache($cacheKey);
    }
    
    /**
     * Test get by advertiser ID.
     *
     * @return void
     */
    public function test_get_advertiser_by_id()
    {
        $response = $this->get('api/advertisers/'.$this->advertiser1->id)->assertStatus(Response::HTTP_OK);

        $this->assertEquals($this->advertiser1->id, $response->getData()->id);
    }

    /**
     * Test get by advertiser ID is cached.
     *
     * @return void
     */
    public function test_get_advertiser_by_id_is_cached()
    {
        $response = $this->get('api/advertisers/'.$this->advertiser1->id)->assertStatus(Response::HTTP_OK);
        
        $cacheKey = AdvertiserService::REDIS_KEY_GET_ADVERTISER_BY_ID.$this->advertiser1->id;
        $cachedSearch = Cache::store('redis')->get($cacheKey);

        $this->assertNotNull($cachedSearch);
        $this->assertEmpty(array_diff($this->advertiser1->toArray(), $cachedSearch->toArray()));
        
        $this->cleanCache($cacheKey);
    }

    /**
     * Test get by advertiser ID is cached and re-cached after an update.
     *
     * @return void
     */
    public function test_get_advertiser_by_id_is_cached_and_recached_after_an_update()
    {
        $this->get('api/advertisers/'.$this->advertiser1->id)->assertStatus(Response::HTTP_OK);
        
        $cacheKey = AdvertiserService::REDIS_KEY_GET_ADVERTISER_BY_ID.$this->advertiser1->id;
        $cachedSearch = Cache::store('redis')->get($cacheKey);

        $this->assertNotNull($cachedSearch);
        $this->assertEmpty(array_diff($this->advertiser1->toArray(), $cachedSearch->toArray()));

        $this->advertiser1->update(['name' => $this->advertiser1->name]);

        $this->get('api/advertisers/'.$this->advertiser1->id)->assertStatus(Response::HTTP_OK);

        $cachedSearchAfterUpdate = Cache::store('redis')->get($cacheKey);
        
        $this->assertNotNull($cachedSearchAfterUpdate);
        $this->assertEmpty(array_diff($this->advertiser1->toArray(), $cachedSearchAfterUpdate->toArray()));
        
        $this->cleanCache($cacheKey);
    }

    /**
     * Test get two different advertisers by advertiser ID does not clear cache
     *
     * @return void
     */
    public function test_get_two_different_advertisers_by_advertiser_id_does_not_clear_cache()
    {
        $this->get('api/advertisers/'.$this->advertiser1->id)->assertStatus(Response::HTTP_OK);
        $this->get('api/advertisers/'.$this->advertiser2->id)->assertStatus(Response::HTTP_OK);
        
        $firstCacheKey = AdvertiserService::REDIS_KEY_GET_ADVERTISER_BY_ID.$this->advertiser1->id;
        $cachedFirstSearch = Cache::store('redis')->get($firstCacheKey);

        $this->assertNotNull($cachedFirstSearch);
        $this->assertEmpty(array_diff($this->advertiser1->toArray(), $cachedFirstSearch->toArray()));
        
        $secondCacheKey = AdvertiserService::REDIS_KEY_GET_ADVERTISER_BY_ID.$this->advertiser2->id;
        $cachedSecondSearch = Cache::store('redis')->get($secondCacheKey);

        $this->assertNotNull($cachedSecondSearch);
        $this->assertEmpty(array_diff($this->advertiser2->toArray(), $cachedSecondSearch->toArray()));
        
        $this->cleanCache($firstCacheKey);
        $this->cleanCache($secondCacheKey);
    }
    
    /**
     * Test get by non existent advertiser ID.
     *
     * @return void
     */
    public function test_get_by_non_existent_advertiser_id_returns_404_error()
    {
        $this->get('api/advertisers/'.$this->nonExistentAdvertiserId)->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
