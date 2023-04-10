<?php

namespace App\Services\Advertiser;

class AdvertiserService implements AdvertiserServiceContract
{
    protected $advertiserRepository;

    public function __construct(AdvertiserServiceContract $advertiserRepository)
    {
        $this->advertiserRepository = $advertiserRepository;
    }

    public function getAllAdvertisers()
    {
        return $this->advertiserRepository->all()->toArray();
    }
}