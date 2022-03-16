<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Product\ProductServiceContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DecrementProductStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    private $cartService;

    public function handle(ProductServiceContract $productService)
    {
        try {
            $productService->decrementProductsQuantity();
        } catch(\Exception $e) {
            Log::error($e);
        }
    }

    public function tags()
    {
        return ['logistics'];
    }
}