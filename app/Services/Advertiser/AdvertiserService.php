<?php

namespace App\Services\Advertiser;

use App\Repositories\Advertiser\AdvertiserRepositoryContract;
use Illuminate\Support\Facades\Cache;

class AdvertiserService implements AdvertiserServiceContract
{
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
        return Cache::store('redis')->remember('getAllAdvertisers', 300, function () {
            return $this->getAllAdvertisers();
        });
    }

    public function getAdvertiserById(int $advertiserId)
    {
        return $this->advertiserRepository->getById($advertiserId); 
    }

    public function getCachedAdvertiserById(int $advertiserId)
    {
        $cachedAdvertiser = Cache::store('redis')->get('getCachedAdvertiserById'.$advertiserId);
        $advertiser = $this->getAdvertiserById($advertiserId);

        // Verify if the searched advertiser is cached and if the attributes are equal
        if ($cachedAdvertiser 
            && $advertiser
            && ($cachedAdvertiser->id == $advertiser->id)
            && ($advertiser != $cachedAdvertiser)
        ) {
            Cache::store('redis')->forget('getCachedAdvertiserById'.$advertiserId);
        }

        return Cache::store('redis')->remember('getCachedAdvertiserById'.$advertiserId, 600, function () use ($advertiserId) {
            return $this->getAdvertiserById($advertiserId);
        });
    }
}