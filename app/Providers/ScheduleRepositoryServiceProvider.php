<?php

namespace App\Providers;

use App\Repositories\Schedule\ScheduleRepositoryContract;
use App\Repositories\Schedule\ScheduleRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class ScheduleRepositoryServiceProvider extends ServiceProvider
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
            ScheduleRepositoryContract::class,
            ScheduleRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [ScheduleRepositoryContract::class];
    }
}
