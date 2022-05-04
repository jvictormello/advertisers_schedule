<?php

namespace App\Providers;

use App\Repositories\Contracts\AvailabilitiesRepositoryContract;
use App\Repositories\AvailabilitiesRepository;
use App\Services\Contracts\AvailabilitiesServiceContract;
use App\Services\AvailabilitiesService;
use Illuminate\Support\ServiceProvider;

class AvailabilitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AvailabilitiesRepositoryContract::class,
            AvailabilitiesRepository::class
        );

        $this->app->bind(
            AvailabilitiesServiceContract::class,
            AvailabilitiesService::class
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
            AvailabilitiesRepositoryContract::class,
            AvailabilitiesServiceContract::class
        ];
    }
}
