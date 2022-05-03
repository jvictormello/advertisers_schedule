<?php

namespace App\Repositories;

use App\Repositories\Contracts\AdvertisersRepositoryContract;
use App\Models\Advertisers;

class AdvertisersRepository extends BaseRepository implements AdvertisersRepositoryContract
{
    public function __construct()
    {
        $this->model = new Advertisers();
    }
}
