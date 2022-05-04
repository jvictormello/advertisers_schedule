<?php

namespace App\Repositories;

use App\Repositories\Contracts\AvailabilitiesRepositoryContract;
use App\Models\Availabilities;
use Illuminate\Support\Collection;

class AvailabilitiesRepository extends BaseRepository implements AvailabilitiesRepositoryContract
{
    protected $model;
    
    public function __construct(Availabilities $model)
    {
        $this->model = $model;
    }

    public function searchByAdvertiserId(int $id): Collection
    {
        return $this->model->with('advertisers')->where('advertiser_id', $id)->orderBy('week_day')->orderBy('start_time')->get();
    }

    public function searchByAvailabilityId(int $id): Collection
    {
        return $this->model->with('advertisers')->where('id', $id)->get();
    }
}
