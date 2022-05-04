<?php

namespace App\Services;

use App\Repositories\Contracts\AdvertisersRepositoryContract;
use App\Services\Contracts\AdvertisersServiceContract;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdvertisersService implements AdvertisersServiceContract
{
    private $advertisersRepository;

    public function __construct(AdvertisersRepositoryContract $advertisersRepository)
    {
        $this->advertisersRepository = $advertisersRepository;
    }

    public function search(Request $request): Collection
    {
        $cacheIdentifier = md5($request->input('query'));
        $cachedResult = Cache::get('advertisers_search_' . $cacheIdentifier);

        if($cachedResult) {
            return collect(json_decode($cachedResult, true));
        }

        $queryArray = json_decode($request->input('query'), true);
        if($queryArray && count($queryArray) > 0)
        {
            $advertisersCollection = $this->advertisersRepository->search($queryArray);
        } else {
            $advertisersCollection = $this->advertisersRepository->getAll();
        }        

        Cache::put('advertisers_search_' . $cacheIdentifier, $advertisersCollection->toJson(), 120);

        return $advertisersCollection;
    }
}
