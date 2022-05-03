<?php

namespace App\Providers;

use App\Repositories\Contracts\AdvertisersRepositoryContract;
use App\Repositories\AdvertisersRepository;
use App\Services\Contracts\AdvertisersServiceContract;
use App\Services\AdvertisersService;
use Illuminate\Support\ServiceProvider;

class AdvertisersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AdvertisersRepositoryContract::class,
            AdvertisersRepository::class
        );

        $this->app->bind(
            AdvertisersServiceContract::class,
            AdvertisersService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [
            AdvertisersRepositoryContract::class,
            AdvertisersServiceContract::class
        ];
    }
}
