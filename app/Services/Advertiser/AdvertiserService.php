<?php

namespace App\Services\Advertiser;

use App\Repositories\Advertiser\AdvertiserRepositoryContract;

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

    public function getAdvertiserById(int $advertiserId)
    {
       return $this->advertiserRepository->getById($advertiserId); 
    }
}