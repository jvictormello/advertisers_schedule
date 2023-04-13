<?php

namespace App\Providers;

use App\Repositories\Notification\NotificationRepositoryContract;
use App\Repositories\Notification\NotificationRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class NotificationRepositoryServiceProvider extends ServiceProvider
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
            NotificationRepositoryContract::class,
            NotificationRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [NotificationRepositoryContract::class];
    }
}
