<?php

namespace App\Providers;

use App\Repositories\Advertiser\AdvertiserRepositoryContract;
use App\Repositories\Advertiser\AdvertiserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AdvertiserRepositoryServiceProvider extends ServiceProvider
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
            AdvertiserRepositoryContract::class,
            AdvertiserRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [AdvertiserRepositoryContract::class];
    }
}
