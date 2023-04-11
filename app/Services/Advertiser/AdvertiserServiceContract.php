<?php

namespace App\Services\Advertiser;

interface AdvertiserServiceContract
{
    public function getAllAdvertisers();
    public function getAllCachedAdvertisers();
    public function getAdvertiserById(int $advertiserId);
    public function getCachedAdvertiserById(int $advertiserId);
}