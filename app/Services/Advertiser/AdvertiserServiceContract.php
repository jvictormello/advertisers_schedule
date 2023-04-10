<?php

namespace App\Services\Advertiser;

interface AdvertiserServiceContract
{
    public function getAllAdvertisers();
    public function getAdvertiserById(int $advertiserId);
}