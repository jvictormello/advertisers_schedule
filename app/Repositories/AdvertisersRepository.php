<?php

namespace App\Repositories;

use App\Repositories\Contracts\AdvertisersRepositoryContract;
use App\Models\Advertisers;

class AdvertisersRepository extends BaseRepository implements AdvertisersRepositoryContract
{
    protected $model;
    
    public function __construct(Advertisers $model)
    {
        $this->model = $model;
    }
}
