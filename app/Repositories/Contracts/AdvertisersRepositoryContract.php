<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface AdvertisersRepositoryContract
{
    public function getAll(): Collection;
    public function search(array $queryArray): Collection;
}
