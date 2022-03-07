<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Repositories\Product\ProductRepositoryContract;
use App\Repositories\Product\ProductRepositoryEloquent;
use App\Services\Product\ProductService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     * @dataProvider cases_product_stock_data_provider
     * @return void
     */
    public function product_stock_validation($quantity, $expected)
    {
        Product::factory()->create([
            'quantity' => $quantity
        ]);

        $productRepository = new ProductRepositoryEloquent(new Product());
        $productService = new ProductService($productRepository);
        $productService->clearProductsWithStockCache();
        $ProductsWithStock = $productService->getProductsWithStock();

        $this->assertEquals($expected, count($ProductsWithStock) > 0);
    }

    public function cases_product_stock_data_provider()
    {
        return [
            'Should be false when quantity is less than or equal to zero' => [
                'quantity' => 0,
                'expected' => false
            ],
            'Should be true when quantity is big than zero' => [
                'quantity' => 1,
                'expected' => true
            ],
        ];
    }

    /**
     * @test
     * @return void
     */

    public function products_list_is_cached()
    {
        Product::factory()->create();

        $productRepository = new ProductRepositoryEloquent(new Product());
        $productService = new ProductService($productRepository);
        $productService->clearProductsWithStockCache();
        $ProductsWithStock = $productService->getProductsWithStock();
        $cachedQuantity = count($ProductsWithStock);

        Product::first()->delete();

        $ProductsWithStockFromCache = $productService->getProductsWithStock();
        $afterDeleteCachedQuantity = count($ProductsWithStockFromCache);

        $this->assertEquals($afterDeleteCachedQuantity, $cachedQuantity);
    }

    /**
     * @test
     * @return void
     */

    public function clear_cached_products_list()
    {
        Product::factory()->create();

        $productRepository = new ProductRepositoryEloquent(new Product());
        $productService = new ProductService($productRepository);
        $productService->clearProductsWithStockCache();
        $ProductsWithStock = $productService->getProductsWithStock();
        $cachedQuantity = count($ProductsWithStock);

        Product::first()->delete();

        $productService->clearProductsWithStockCache();
        $ProductsWithStockFromCache = $productService->getProductsWithStock();
        $afterDeleteCachedQuantity = count($ProductsWithStockFromCache);

        $this->assertNotEquals($afterDeleteCachedQuantity, $cachedQuantity);
    }
}
