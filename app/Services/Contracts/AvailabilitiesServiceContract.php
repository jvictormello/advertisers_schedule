<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface AvailabilitiesServiceContract
{
    public function searchByAdvertiserId(int $id): Collection;
    public function searchByAvailabilityId(int $id): Collection;    
}
