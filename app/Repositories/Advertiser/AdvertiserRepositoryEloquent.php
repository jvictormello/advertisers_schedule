<?php

namespace App\Repositories\Advertiser;

use App\Models\Advertiser;
use App\Repositories\BaseRepositoryEloquent;

class AdvertiserRepositoryEloquent extends BaseRepositoryEloquent implements AdvertiserRepositoryContract
{
    protected $model;

    public function __construct(Advertiser $advertiser)
    {
        $this->model = $advertiser;
    }

}
