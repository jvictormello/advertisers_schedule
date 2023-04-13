<?php

namespace App\Providers;

use App\Services\Notification\NotificationService;
use App\Services\Notification\NotificationServiceContract;
use Illuminate\Support\ServiceProvider;

class NotificationServiceServiceProvider extends ServiceProvider
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
            NotificationServiceContract::class,
            NotificationService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [NotificationServiceContract::class];
    }
}
