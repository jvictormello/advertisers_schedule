<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryEloquent;
use App\Repositories\Product\ProductRepositoryContract;
use App\Repositories\Product\ProductRepositoryEloquent;
use App\Services\Product\ProductService;
use App\Services\Product\ProductServiceContract;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(PaymentMethodRepositoryContract::class, PaymentMethodRepositoryEloquent::class);
        $this->app->bind(ProductRepositoryContract::class, ProductRepositoryEloquent::class);
        $this->app->bind(ProductServiceContract::class, ProductService::class);
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
