<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface AdvertisersServiceContract
{
    public function search(Request $request): Collection;
}
