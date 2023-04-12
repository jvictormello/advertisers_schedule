<?php

namespace App\Services\Advertiser;

use App\Repositories\Advertiser\AdvertiserRepositoryContract;
use Illuminate\Support\Facades\Cache;

class AdvertiserService implements AdvertiserServiceContract
{
    const FIVE_MINUTES_IN_SECONDS = 300;
    const TEN_MINUTES_IN_SECONDS = 600;
    const REDIS_KEY_GET_ALL_ADVERTISERS = 'get_all_advertisers_cached';
    const REDIS_KEY_GET_ADVERTISER_BY_ID = 'get_advertiser_by_id_cached';

    protected $advertiserRepository;

    public function __construct(AdvertiserRepositoryContract $advertiserRepository)
    {
        $this->advertiserRepository = $advertiserRepository;
    }

    public function getAllAdvertisers()
    {
        return $this->advertiserRepository->all()->toArray();
    }

    public function getAllCachedAdvertisers()
    {
        return Cache::store('redis')->remember(self::REDIS_KEY_GET_ALL_ADVERTISERS, self::FIVE_MINUTES_IN_SECONDS, function () {
            return $this->getAllAdvertisers();
        });
    }

    public function getAdvertiserById(int $advertiserId)
    {
        return $this->advertiserRepository->getById($advertiserId);
    }

    public function getCachedAdvertiserById(int $advertiserId)
    {
        $cachedAdvertiser = Cache::store('redis')->get(self::REDIS_KEY_GET_ADVERTISER_BY_ID.$advertiserId);
        $advertiser = $this->getAdvertiserById($advertiserId);

        // Verify if the searched advertiser is cached and if the attributes are equal
        if ($cachedAdvertiser
            && $advertiser
            && ($cachedAdvertiser->id == $advertiser->id)
            && ($advertiser != $cachedAdvertiser)
        ) {
            Cache::store('redis')->forget(self::REDIS_KEY_GET_ADVERTISER_BY_ID.$advertiserId);
        }

        return Cache::store('redis')->remember(self::REDIS_KEY_GET_ADVERTISER_BY_ID.$advertiserId, self::TEN_MINUTES_IN_SECONDS, function () use ($advertiserId) {
            return $this->getAdvertiserById($advertiserId);
        });
    }
}
