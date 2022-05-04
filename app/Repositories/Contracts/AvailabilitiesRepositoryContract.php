<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface AvailabilitiesRepositoryContract
{
    public function getAll(): Collection;
    public function search(array $queryArray): Collection;
    public function searchByAdvertiserId(int $id): Collection;
    public function searchByAvailabilityId(int $id): Collection;    
}
