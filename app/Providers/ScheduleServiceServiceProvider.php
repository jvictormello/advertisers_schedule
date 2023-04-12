<?php

namespace App\Providers;

use App\Services\Schedule\ScheduleService;
use App\Services\Schedule\ScheduleServiceContract;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceServiceProvider extends ServiceProvider
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
            ScheduleServiceContract::class,
            ScheduleService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [ScheduleServiceContract::class];
    }
}
