<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(PaymentMethodRepositoryContract::class, PaymentMethodRepositoryEloquent::class);
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
