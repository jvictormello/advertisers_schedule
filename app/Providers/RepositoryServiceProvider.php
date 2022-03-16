<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryEloquent;
use App\Repositories\Product\ProductRepositoryContract;
use App\Repositories\Product\ProductRepositoryEloquent;
use App\Repositories\Sale\SaleRepositoryContract;
use App\Repositories\Sale\SaleRepositoryEloquent;
use App\Services\PaymentMethod\PaymentMethodService;
use App\Services\PaymentMethod\PaymentMethodServiceContract;
use App\Services\Product\ProductService;
use App\Services\Product\ProductServiceContract;
use App\Services\Sale\SaleService;
use App\Services\Sale\SaleServiceContract;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PaymentMethodRepositoryContract::class, PaymentMethodRepositoryEloquent::class);
        $this->app->bind(PaymentMethodServiceContract::class, PaymentMethodService::class);

        $this->app->bind(ProductRepositoryContract::class, ProductRepositoryEloquent::class);
        $this->app->bind(ProductServiceContract::class, ProductService::class);

        $this->app->bind(SaleRepositoryContract::class, SaleRepositoryEloquent::class);
        $this->app->bind(SaleServiceContract::class, SaleService::class);
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
