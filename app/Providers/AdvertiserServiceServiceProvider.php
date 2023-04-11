<?php

namespace App\Providers;

use App\Services\Advertiser\AdvertiserService;
use App\Services\Advertiser\AdvertiserServiceContract;
use Illuminate\Support\ServiceProvider;

class AdvertiserServiceServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AdvertiserServiceContract::class,
            AdvertiserService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [AdvertiserServiceContract::class];
    }
}
